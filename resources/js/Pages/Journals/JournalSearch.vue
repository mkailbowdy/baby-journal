<script setup lang="ts">
import { JournalInterface } from '@/Enums/JournalInterface';
import { debounce } from 'lodash';
import { computed, ref } from 'vue';
const props = defineProps(['journals']);

const searchQuery = ref('');
const searchResults = ref<JournalInterface[]>([]);
const searchResultsExtracted = ref<JournalInterface[]>([]);

const localJournals = computed(() => {
    return props.journals;
});

const performSearch = debounce(() => {
    // the user must type more than 2 characters into the search bar
    if (searchQuery.value.length < 2) {
        searchResults.value = [];
        return;
    }
    // Client-side filtering
    searchResults.value = localJournals.value.filter((item: JournalInterface) =>
        item.entry.toLowerCase().includes(searchQuery.value.toLowerCase()),
    );

    // Create a shallow copy of searchResults using map() and assign it to searchResultsExtracted
    // By creating a shallow copy, you avoid directly mutating the objects in searchResults.value when modifying the entry field in extractWithContext.

    searchResultsExtracted.value = searchResults.value.map((item) => ({
        ...item,
    }));

    extractWithContext(searchQuery.value);
}, 300);

const selectResult = (result: JournalInterface) => {
    // Handle result selection
    searchQuery.value = result.entry;
    searchResults.value = [];
};

// For every item in the searchResults array, I want to find the searchQuery term and return only the sentence that it is in.
// I also want the searchQuery term to be highlighted yellow

function extractWithContext(word: string, contextLength: number = 40) {
    searchResultsExtracted.value.forEach((journal: JournalInterface) => {
        const index = journal.entry.indexOf(word);
        if (index === -1) {
            return 'The word ' + word + ' does not exist';
        }

        // Calculate start and end indices for slicing
        const start = Math.max(0, index - contextLength);
        const end = Math.min(
            journal.entry.length,
            index + word.length + contextLength,
        );

        journal.entry = journal.entry.slice(start, end);
    });
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
                v-if="searchResults.length"
                class="absolute z-10 mt-1 w-full rounded border bg-white shadow-lg"
            >
                <div
                    v-for="result in searchResultsExtracted"
                    :key="result.id"
                    class="cursor-pointer truncate p-2 hover:bg-gray-100"
                    @click="selectResult(result)"
                >
                    {{ result.entry }}
                </div>
            </div>
        </div>
    </div>
</template>
