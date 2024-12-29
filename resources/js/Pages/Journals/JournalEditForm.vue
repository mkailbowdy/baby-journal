<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteJournalConfirmation from '@/Pages/Journals/DeleteJournalConfirmation.vue';
import { Journal } from '@/types/Journal';
import { useForm } from '@inertiajs/vue3';
import BaseInput from '../../Pages/Journals/BaseInput.vue';

const emit = defineEmits([
    'journalUpdated',
    'journalDeleted',
    'journalCancelled',
]);
const props = defineProps(['journal']);
console.log(props.journal.id);
const form = useForm({
    entry: props.journal.entry,
    date: props.journal.date,
    height: props.journal.height,
    weight: props.journal.weight,
});
const currentBaby = route().params.baby;

function updateJournal(journal: Journal) {
    form.put(
        route('babies.journals.update', {
            journal: journal,
            baby: currentBaby,
        }),
        {
            preserveScroll: true,
            onSuccess: () => {
                emit('journalUpdated', journal);
            },
        },
    );
}
function deleteJournal(journal: Journal) {
    // Inertia's form helpers refreshes the props
    form.delete(
        route('babies.journals.destroy', {
            journal: journal,
            baby: currentBaby,
        }),
        {
            onSuccess: () => {
                form.reset();
                emit('journalDeleted');
            },
        },
    );
}
</script>
<template>
    <AuthenticatedLayout>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
            <div class="mt-2 divide-y rounded-lg bg-white p-4 shadow-md">
                <form @submit.prevent="updateJournal(props.journal)">
                    <img
                        v-if="journal.image"
                        alt="profile picture"
                        :src="`../../../../storage/${journal.image}`"
                    />
                    <BaseInput
                        label="Date"
                        v-model="form.date"
                        type="date"
                        name="height"
                        id="height"
                        min="1"
                        :class="
                            form.errors.date
                                ? 'border-red-500'
                                : 'border-gray-300'
                        "
                    />
                    <InputError :message="form.errors.date" class="mt-2" />

                    <BaseInput
                        label="Height"
                        v-model="form.height"
                        type="number"
                        name="height"
                        id="height"
                        min="1"
                        :class="
                            form.errors.height
                                ? 'border-red-500'
                                : 'border-gray-300'
                        "
                    />
                    <InputError :message="form.errors.height" class="mt-2" />

                    <BaseInput
                        label="Weight"
                        v-model="form.weight"
                        type="number"
                        name="weight"
                        id="weight"
                        min="1"
                        :class="
                            form.errors.weight
                                ? 'border-red-500'
                                : 'border-gray-300'
                        "
                    />
                    <InputError :message="form.errors.weight" class="mt-2" />

                    <textarea
                        v-model="form.entry"
                        class="mt-4 w-full rounded-md border-gray-300 text-gray-900 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    ></textarea>
                    <InputError :message="form.errors.entry" class="mt-2" />
                    <div class="mt-4 flex justify-around gap-2">
                        <DeleteJournalConfirmation
                            @journal-deleted="deleteJournal(props.journal)"
                        />
                        <a
                            :href="
                                route('babies.journals.index', {
                                    baby: currentBaby,
                                })
                            "
                            class="inline-flex items-center rounded-md border border-transparent bg-gray-500 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-400"
                            >Cancel
                        </a>
                        <PrimaryButton class="bg-emerald-500 hover:bg-emerald-400"
                            >Save</PrimaryButton
                        >
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
