<script setup lang="ts">
import { useInfiniteScroll } from '@/Composables/useInfiniteScroll';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import JournalDetails from '@/Pages/Journals/JournalDetails.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    journals: {
        type: Object,
        required: true,
    },
    baby: {
        type: Object,
        required: true,
    },
});

const landmark = ref(null);

const { items, canLoadMoreItems } = useInfiniteScroll('journals', landmark);
</script>
<template>
    <AuthenticatedLayout>
        <template #header>
            <Head title="Journals" />
            <div class="flex items-center justify-between">
                <h1 class="text-center text-4xl font-bold">
                    {{ baby.first_name }}'s Journal
                </h1>
                <a
                    :href="
                        route('babies.journals.create', {
                            baby: baby,
                        })
                    "
                    class="text-2xl"
                    ><svg
                        class="inline-block fill-emerald-500"
                        height="36px"
                        width="36px"
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
                        </g></svg
                ></a>
            </div>
        </template>

        <div v-if="journals.data.length">
            <div v-for="journal in items" :key="journal.id">
                <div class="mx-auto max-w-2xl p-4 sm:p-2 lg:p-8">
                    <div class="mt-2 divide-y rounded-lg bg-white shadow-md">
                        <JournalDetails :journal="journal" />
                    </div>
                </div>
            </div>
        </div>

        <span v-if="!canLoadMoreItems" class="ml-4"
            >All journals loaded :)</span
        >

        <div ref="landmark">
            <!--            height added to make sure entry.isIntersecting is true at the bottom of the page-->
        </div>
    </AuthenticatedLayout>
</template>
