<script setup lang="ts">
import NavLink from '@/Components/NavLink.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BaseInput from '@/Pages/Journals/BaseInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps(['babies']);
function saveToDatabase() {
    console.log('submit button clicked');
    // Inertia's form helpers refreshes the props
    form.post(route('babies.store'), {
        onSuccess: () => {
            console.log('success');
            form.reset();
        },
        onError: (errors) => {
            console.log(':error' + errors);
        },
    });
}
const form = useForm({
    first_name: '',
});
</script>
<template>
    <AuthenticatedLayout>
        <template #header>
            <Head title="Babies" />
            <h1 class="text-xl font-semibold leading-tight text-gray-800">
                Whose journal would you like to open?
            </h1>
        </template>
        <div v-if="babies" class="flex w-full flex-col">
            <div v-for="baby in babies" :key="baby.id" class="bg-emerald-300">
                <NavLink
                    class="w-full"
                    :href="route('babies.journals.index', { baby: baby })"
                    ><p class="text-4xl">{{ baby.first_name }}</p></NavLink
                >
            </div>
        </div>
        <div>
            <form @submit.prevent="saveToDatabase()">
                <BaseInput
                    label="Add another child?"
                    type="text"
                    v-model="form.first_name"
                />
                <div v-if="form.errors.first_name" class="error">
                    {{ form.errors.first_name }}
                </div>
                <button>Submit</button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
