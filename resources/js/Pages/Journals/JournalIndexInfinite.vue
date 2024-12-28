<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import JournalDetails from '@/Pages/Journals/JournalDetails.vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

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

const items = ref(props.journals.data);

const initialUrl = usePage().url;

const loadMoreItems = () => {
    router.get(
        props.journals.next_page_url,
        {},
        {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                window.history.replaceState({}, '', initialUrl);
                items.value = [...items.value, ...props.journals.data];

            },
        },
    );
};
</script>
<template>
    <AuthenticatedLayout>
        <div v-if="journals.data.length">
            <div v-for="journal in items" :key="journal.id">
                <div class="mx-auto max-w-2xl p-4 sm:p-6 lg:p-8">
                    <div class="mt-6 divide-y rounded-lg bg-white shadow-md">
                        <JournalDetails :journal="journal" />
                    </div>
                </div>
            </div>
        </div>
        <Link @click="loadMoreItems">Load more</Link>
    </AuthenticatedLayout>
</template>
