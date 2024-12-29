import { router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

export function useInfiniteScroll(propName) {
    const value = () => usePage().props[propName];

    const items = ref(value().data);

    const initialUrl = usePage().url;

    const loadMoreItems = () => {
        if (!value().next_page_url) {
            return;
        }

        router.get(
            value().next_page_url,
            {},
            {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    window.history.replaceState({}, '', initialUrl);
                    items.value = [...items.value, ...value().data];
                },
            },
        );
    };

    return { items, loadMoreItems };
}
