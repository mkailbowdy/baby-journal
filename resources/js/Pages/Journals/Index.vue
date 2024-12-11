<script setup lang="ts">
import Journal from '@/Components/Journal.vue';
import { JournalInterface } from '@/Enums/JournalInterface';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import JournalForm from '@/Pages/Journals/JournalForm.vue';
import JournalSearch from '@/Pages/Journals/JournalSearch.vue';
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import NavBar from "@/Components/NavBar.vue";

const props = defineProps(['journals']);
const open = ref(false);
const localJournals = computed(() => props.journals);
const activeJournal = ref<JournalInterface | null>(localJournals.value[0]);

const updateActiveJournal = (journalId: number): void => {
    activeJournal.value = localJournals.value.find(
        (journal: JournalInterface) => journal.id === journalId,
    );
};

const formSubmittedHandler = () => {
    activeJournal.value = localJournals.value[0];
};
</script>
<template>
    <Head title="Journals" />
    <AuthenticatedLayout>
        <div class="mx-auto max-w-2xl p-4 sm:p-6 lg:p-8">
            <div v-if="!open" class="flex flex-row items-center gap-4">
                <button @click="open = !open">
                    <svg
                        fill="#000000"
                        height="24px"
                        width="24px"
                        version="1.1"
                        id="Capa_1"
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
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
                    @activeJournal="updateActiveJournal"
                />
            </div>
            <div v-else>
                <JournalForm
                    @formSubmitted="formSubmittedHandler"
                    @cancelled="open = !open"
                />
            </div>
            <div class="mt-6 divide-y rounded-lg bg-white shadow-sm">
                <Journal
                    v-if="activeJournal"
                    :journal="activeJournal"
                    :key="activeJournal.id"
                />
            </div>

            <!--            <div class="mt-6 divide-y rounded-lg bg-white shadow-sm">-->
            <!--                <Journal-->
            <!--                    v-for="journal in localJournals"-->
            <!--                    :key="journal.id"-->
            <!--                    :journal="journal"-->
            <!--                />-->
            <!--            </div>-->
        </div>
    </AuthenticatedLayout>
</template>
