<script setup lang="ts">
import { Journal } from '@/types/Journal';
import { debounce } from 'lodash';
import { computed, ref } from 'vue';

const props = defineProps(['journals']);
const emit = defineEmits(['activeJournal']);
const searchQuery = ref('');
const searchResults = ref<Journal[]>([]);
const searchResultsExtracted = ref<{ id: number; entry: string }[]>([]);

const localJournals = computed(() => props.journals);

const performSearch = debounce(() => {
    if (searchQuery.value.length < 2) {
        searchResults.value = [];
        searchResultsExtracted.value = [];
        return;
    }

    searchResults.value = localJournals.value.filter((item: Journal) =>
        item.entry.toLowerCase().includes(searchQuery.value.toLowerCase()),
    );

    searchResultsExtracted.value = searchResults.value.map(
        (item): { id: number; entry: string } => {
            return {
                id: item.id!,
                entry: extractWithContext(item.entry, searchQuery.value),
            };
        },
    );
}, 300);

const selectResult = (resultId: number) => {
    emit('activeJournal', resultId);
    searchQuery.value = '';
    searchResults.value = [];
    searchResultsExtracted.value = [];
};

function extractWithContext(
    entry: string,
    word: string,
    contextLength: number = 20,
): string {
    const index = entry.toLowerCase().indexOf(word.toLowerCase());
    if (index === -1) return entry;

    const start = Math.max(0, index - contextLength);
    const end = Math.min(entry.length, index + word.length + contextLength);

    const before = entry.slice(start, index);
    const match = entry.slice(index, index + word.length);
    const after = entry.slice(index + word.length, end);

    return `${before}<span class="bg-yellow-500">${match}</span>${after}`;
}
</script>

<template>
    <div class="flex w-full flex-col">
        <div class="relative w-full">
            <input
                v-model="searchQuery"
                type="search"
                placeholder="keyword"
                class="w-full"
                @input="performSearch"
            />
            <div
                v-if="searchResultsExtracted.length"
                class="absolute mt-1 w-full rounded border bg-white shadow-lg"
            >
                <div
                    v-for="journal in searchResultsExtracted"
                    :key="journal.id"
                    class="cursor-pointer truncate p-2 hover:bg-gray-100"
                    @click="selectResult(journal.id)"
                >
                    <p v-html="journal.entry" class="truncate"></p>
                </div>
            </div>
        </div>
    </div>
</template>
