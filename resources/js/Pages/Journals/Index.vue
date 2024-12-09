<script setup>
import InputError from '@/Components/InputError.vue';
import Journal from '@/Components/Journal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps(['journals']);

const form = useForm({
    date: '',
    height: 0,
    weight: 0,
    entry: '',
});
</script>
<template>
    <Head title="Journals" />
    <AuthenticatedLayout>
        <div class="mx-auto max-w-2xl p-4 sm:p-6 lg:p-8">
            <form
                @submit.prevent="
                    form.post(route('journals.store'), {
                        onSuccess: () => form.reset(),
                    })
                "
            >
                <input v-model="form.date" type="date" name="date" id="date" />
                <input
                    v-model="form.height"
                    type="number"
                    name="height"
                    id="height"
                />
                <input
                    v-model="form.weight"
                    type="number"
                    name="weight"
                    id="weight"
                />
                <textarea
                    v-model="form.entry"
                    placeholder="What did your child do today?"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                ></textarea>
                <InputError :message="form.errors.entry" class="mt-2" />
                <PrimaryButton class="mt-4 bg-teal-500">Submit</PrimaryButton>
            </form>

            <div class="mt-6 divide-y rounded-lg bg-white shadow-sm">
                <Journal v-for="journal in journals" :key="journal.id" :journal="journal" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
