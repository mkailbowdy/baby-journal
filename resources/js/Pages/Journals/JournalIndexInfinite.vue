<script setup lang="ts">
import { useInfiniteScroll } from '@/Composables/useInfiniteScroll';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import JournalDetails from '@/Pages/Journals/JournalDetails.vue';
import { ref } from 'vue';

defineProps({
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
