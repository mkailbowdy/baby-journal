<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DeleteJournalConfirmation from '@/Pages/Journals/DeleteJournalConfirmation.vue';
import { Journal } from '@/types/Journal';
import { useForm } from '@inertiajs/vue3';

const emit = defineEmits([
    'journalUpdated',
    'journalDeleted',
    'journalCancelled',
]);
const props = defineProps(['journal']);

const form = useForm({
    entry: props.journal.entry,
    date: props.journal.date,
    height: props.journal.height,
    weight: props.journal.weight,
});
function updateJournal(journal: Journal) {
    form.put(route('journals.update', journal.id), {
        preserveScroll: true,
        onSuccess: () => {
            emit('journalUpdated', journal);
        },
    });
}
function deleteJournal(journal: Journal) {
    // Inertia's form helpers refreshes the props
    form.delete(route('journals.destroy', journal.id), {
        onSuccess: () => {
            form.reset();
            emit('journalDeleted');
        },
    });
}
</script>
<template>
    <form @submit.prevent="updateJournal(props.journal)">
        <div class="mb-4">
            <img alt="profile picture" :src="`storage/${journal.image}`" />
        </div>
        <input v-model="form.date" type="date" />
        <input v-model="form.height" type="number" />
        <input v-model="form.weight" type="number" />
        <textarea
            v-model="form.entry"
            class="mt-4 w-full rounded-md border-gray-300 text-gray-900 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
        ></textarea>
        <InputError :message="form.errors.entry" class="mt-2" />
        <div class="mt-4 flex justify-end gap-2">
            <DeleteJournalConfirmation
                @journal-deleted="deleteJournal(props.journal)"
            />
            <PrimaryButton
                class="bg-gray-400 hover:bg-gray-500"
                @click.prevent="
                    form.reset();
                    form.clearErrors();
                    emit('journalCancelled');
                "
            >
                Cancel
            </PrimaryButton>
            <PrimaryButton class="bg-gray-800 hover:bg-gray-700"
                >Save</PrimaryButton
            >
        </div>
    </form>
</template>
