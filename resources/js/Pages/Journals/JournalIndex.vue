<script setup lang="ts">
import { useFlashMessage } from '@/Composables/useFlashMessage';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import JournalDetails from '@/Pages/Journals/JournalDetails.vue';
import JournalForm from '@/Pages/Journals/JournalForm.vue';
import JournalSearch from '@/Pages/Journals/JournalSearch.vue';
import type { Journal } from '@/types/Journal';
import { MessageType } from '@/types/MessageType';
import { Head, router } from "@inertiajs/vue3";
import { computed, ref } from 'vue';
import { route } from '../../../../vendor/tightenco/ziggy';

// const props = defineProps<{
//     journals: Journal[];
// }>();
const props = defineProps(['journals', 'baby']);
// console.log(props.journals);
const currentBaby = route().params.baby;
const babyName = computed(() => {
    return props.baby.first_name;
});

const open = ref(false);
const localJournals = computed(() => props.journals.data);
const recentJournal = computed(() => {
    return localJournals.value[0] || null;
});
const activeJournal = ref<Journal | null>(recentJournal.value);

// The useFlashMessage() function returns an object, and the destructuring syntax
// extracts the message, messageType, and showMessage properties into local variables with the same names
const { message, messageType, showMessage, messageDescription, messageClass } =
    useFlashMessage();
//Without destructuring, you'd need to write:
// const flashMessage = useFlashMessage();
// const message = flashMessage.message;
// const messageType = flashMessage.messageType;
// const showMessage = flashMessage.showMessage;

const findActiveJournal = (journalToFind: Journal): void => {
    activeJournal.value =
        localJournals.value.find(
            (journal: Journal) => journal.id === journalToFind.id,
        ) || null;
};

const setActiveJournal = (flashMessage: MessageType) => {
    showMessage(flashMessage);
    activeJournal.value = recentJournal.value;
};

</script>
<template>
    <AuthenticatedLayout>
        <template #header>
            <Head title="Journals" />
            <h1 class="text-center text-4xl font-bold">
                {{ babyName }}'s Journal
            </h1>
        </template>
        <Transition>
            <div v-if="message" class="text-center" :class="messageClass">
                {{ messageDescription(messageType as MessageType) }}
            </div>
        </Transition>
        <div class="mx-auto max-w-2xl p-4 sm:p-6 lg:p-8">
            <div v-if="!open" class="flex flex-row items-center gap-4">
                <button @click="open = !open">
                    <svg
                        fill="#000000"
                        height="24px"
                        width="24px"
                        id="Capa_1"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 490 490"
                        xml:space="preserve"
                    >
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g
                            id="SVGRepo_tracerCarrier"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        ></g>
                        <g id="SVGRepo_iconCarrier">
                            <g>
                                <g>
                                    <g>
                                        <path
                                            d="M227.8,174.1v53.7h-53.7c-9.5,0-17.2,7.7-17.2,17.2s7.7,17.2,17.2,17.2h53.7v53.7c0,9.5,7.7,17.2,17.2,17.2 s17.1-7.7,17.1-17.2v-53.7h53.7c9.5,0,17.2-7.7,17.2-17.2s-7.7-17.2-17.2-17.2h-53.7v-53.7c0-9.5-7.7-17.2-17.1-17.2 S227.8,164.6,227.8,174.1z"
                                        ></path>
                                        <path
                                            d="M71.7,71.7C25.5,118,0,179.5,0,245s25.5,127,71.8,173.3C118,464.5,179.6,490,245,490s127-25.5,173.3-71.8 C464.5,372,490,310.4,490,245s-25.5-127-71.8-173.3C372,25.5,310.5,0,245,0C179.6,0,118,25.5,71.7,71.7z M455.7,245 c0,56.3-21.9,109.2-61.7,149s-92.7,61.7-149,61.7S135.8,433.8,96,394s-61.7-92.7-61.7-149S56.2,135.8,96,96s92.7-61.7,149-61.7 S354.2,56.2,394,96S455.7,188.7,455.7,245z"
                                        ></path>
                                    </g>
                                </g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                            </g>
                        </g>
                    </svg>
                </button>
                <JournalSearch
                    :journals="localJournals"
                    @activeJournal="findActiveJournal"
                />
            </div>
            <div v-else>
                <JournalForm
                    @formSubmitted="setActiveJournal"
                    @close-form="open = !open"
                    @form-error="showMessage(MessageType.ERROR)"
                    :journal="recentJournal"
                    :baby-id="currentBaby"
                />
            </div>
            <div class="mt-6 divide-y rounded-lg bg-white shadow-md">
                <JournalDetails
                    v-if="activeJournal"
                    :journal="activeJournal"
                    :key="activeJournal.id"
                    @journal-updated="findActiveJournal"
                    @journal-deleted="setActiveJournal"
                />
            </div>
        </div>
        <div v-if="journals.data.length">
            <div v-for="journal in localJournals" :key="journal.id">
                <div class="mx-auto max-w-2xl p-4 sm:p-6 lg:p-8">
                    <div class="mt-6 divide-y rounded-lg bg-white shadow-md">
                        <JournalDetails :journal="journal" />
                    </div>
                </div>
            </div>
        </div>
        <div v-if="props.journals.links" class="pagination">
            <button
                v-for="link in props.journals.links"
                :key="link.label"
                :disabled="!link.url"
                :class="{ active: link.active }"
                @click.prevent="router.visit(link.url)"
                v-html="link.label"
            ></button>
        </div>
    </AuthenticatedLayout>
</template>
<style>
/* we will explain what these classes do next! */
.v-enter-active,
.v-leave-active {
    transition: all 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
    transform: translateY(-20%);
}
</style>
