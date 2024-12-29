<script setup lang="ts">
import { useInfiniteScroll } from '@/Composables/useInfiniteScroll';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import JournalDetails from '@/Pages/Journals/JournalDetails.vue';
import { onMounted, ref } from 'vue';

// const props = defineProps<{
//     journals: Journal[];
// }>();
// const props = defineProps(['journals', 'baby']);

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

const { items, loadMoreItems } = useInfiniteScroll('journals');

const observer = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                console.log('Intersected!');
                loadMoreItems();
            }
        });
    },
    {
        rootMargin: '0px 0px 150px 0px',
    },
);

const landmark = ref(null);

onMounted(() => {
    observer.observe(landmark.value!);
});
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

        <div ref="landmark">
            <!--            height added to make sure entry.isIntersecting is true at the bottom of the page-->
        </div>
    </AuthenticatedLayout>
</template>
