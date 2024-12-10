<script setup lang="ts">
import { debounce } from 'lodash';
import { computed, ref } from 'vue';
interface Journal {
    id: number;
    entry: string;
    date: string;
    height: number;
    weight: number;
}
const props = defineProps(['journals']);

const searchQuery = ref('');
const searchResults = ref<Journal[]>([]);
const localJournals = computed(() => {
    return props.journals;
});

const performSearch = debounce(() => {
    if (searchQuery.value.length < 2) {
        searchResults.value = [];
        return;
    }
    // Option 1: Client-side filtering
    searchResults.value = localJournals.value.filter((item: Journal) =>
        item.entry.toLowerCase().includes(searchQuery.value.toLowerCase()),
    );
}, 300);

const selectResult = (result: Journal) => {
    // Handle result selection
    searchQuery.value = result.entry;
    searchResults.value = [];
};
</script>

<template>
    <div class="w-full">
        <input
            v-model="searchQuery"
            type="search"
            placeholder="keyword"
            class="w-full"
            @input="performSearch"
        />
        <div>
            <p>{{ searchQuery }}</p>
        </div>
        <div
            v-if="searchResults.length"
            class="absolute z-10 mt-1 w-full rounded border bg-white shadow-lg"
        >
            <div
                v-for="result in searchResults"
                :key="result.id"
                class="cursor-pointer p-2 hover:bg-gray-100"
                @click="selectResult(result)"
            >
                {{ result.entry }}
            </div>
        </div>
    </div>
</template>
