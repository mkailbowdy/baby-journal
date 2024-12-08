<script setup lang="ts">
import { useJournalsStore } from '@/stores/journals.ts';
import { computed, onMounted, ref } from 'vue';

const date = ref('');
const height = ref(0);
const weight = ref(0);
const journal = ref('');
const store = useJournalsStore();
const localJournals = computed(() => store.journals);
const newestJournal = computed(() => store.journals[store.journals.length - 1]);

async function addJournalsAndClear(
    newDate: string,
    newHeight: number,
    newWeight: number,
    newJournal: string,
) {
    await store.addJournals(newDate, newHeight, newWeight, newJournal);
    height.value = 0;
    weight.value = 0;
    journal.value = '';
    await store.getJournals();
}

onMounted(async () => {
    await store.getJournals();
    console.log(localJournals.value[1].height);
    console.log('Newest value is: ' + newestJournal.value.id);
    console.log(
        'The journal I found is: ' +
            store.getJournal('3JX3avoWlMVuNBYoqkut').height +
            'and the id is: ' +
            store.getJournal('3JX3avoWlMVuNBYoqkut').id,
    );
});
</script>

<template>
    <main>
        <div class="m-4">
            <form
                @submit.prevent="
                    addJournalsAndClear(date, height, weight, journal)
                "
            >
                <input
                    v-model="date"
                    name="date"
                    id="date"
                    type="date"
                    class="border"
                />
                <input
                    v-model="height"
                    name="height"
                    id="height"
                    type="number"
                    class="border"
                />
                <input
                    v-model="weight"
                    name="weight"
                    id="weight"
                    type="number"
                    class="border"
                />
                <textarea
                    v-model="journal"
                    name="journal"
                    id="journal"
                    class="border"
                ></textarea>
                <button>Add</button>
            </form>
        </div>

        <div v-if="localJournals">
            <div v-for="journal in localJournals" :key="journal.id">
                <RouterLink
                    class="text-teal-500"
                    :to="{ name: 'JournalDetails', params: { id: journal.id } }"
                    >{{ journal.id }}
                </RouterLink>
            </div>
        </div>
    </main>
</template>
