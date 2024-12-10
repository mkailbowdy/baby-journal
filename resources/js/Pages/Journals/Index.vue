<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import Journal from '@/Components/Journal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';

defineProps(['journals']);

// useForm( initializes a reactive object)
const form = useForm({
    date: '',
    height: 0,
    weight: 0,
    entry: '',
});

const message = ref(false);
const success = ref(false);
const error = ref(false);
const status = reactive({
    'bg-green-500': success,
    'bg-red-500': error,
});
function flashMessage(result: string) {
    message.value = true;
    if (result === 'success') {
        success.value = true;
    } else if (result === 'error') {
        error.value = true;
    }
    setTimeout(() => {
        message.value = false;
        success.value = false;
        error.value = false;
    }, 3000);
}

function saveToDatabase() {
    form.post(route('journals.store'), {
        onSuccess: () => {
            form.reset();
            flashMessage('success');
        },
        onError: () => {
            flashMessage('error');
        },
    });
}
</script>
<template>
    <Head title="Journals" />
    <AuthenticatedLayout>
        <Transition>
            <div v-if="message">
                <p :class="status">Journal added!</p>
            </div>
        </Transition>

        <div class="mx-auto max-w-2xl p-4 sm:p-6 lg:p-8">
            <form @submit.prevent="saveToDatabase()">
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
                <Journal
                    v-for="journal in journals"
                    :key="journal.id"
                    :journal="journal"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style>
/* we will explain what these classes do next! */
.v-enter-active,
.v-leave-active {
    transition: all 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
    transform: translateY(-20%);
}
</style>
