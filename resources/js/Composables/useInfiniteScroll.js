import { useIntersect } from '@/Composables/useIntersect.js';
import { router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

export function useInfiniteScroll(propName, landmark) {
    const value = () => usePage().props[propName];

    const items = ref(value().data);

    const initialUrl = usePage().url;

    const canLoadMoreItems = computed(() => {
        return value().next_page_url !== null;
    });

    const loadMoreItems = () => {
        if (!canLoadMoreItems.value) {
            return;
        }

        router.get(
            value().next_page_url,
            {},
            {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    console.log(initialUrl);
                    window.history.replaceState({}, '', initialUrl);
                    items.value = [...items.value, ...value().data];
                },
            },
        );
    };

    if (landmark !== null) {
        useIntersect(landmark, loadMoreItems, {
            rootMargin: '0px 0px 150px 0px',
        });
    }

    return {
        items,
        loadMoreItems,
        reset: () => (items.value = value().data),
        canLoadMoreItems,
    };
}
