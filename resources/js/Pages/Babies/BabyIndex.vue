<script setup lang="ts">
import NavLink from '@/Components/NavLink.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from "@inertiajs/vue3";

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
        </template>
        <form @submit.prevent="saveToDatabase()">
            <input type="text" v-model="form.first_name" />
            <div v-if="form.errors.first_name" class="error">
                {{ form.errors.first_name }}
            </div>
            <button>Submit</button>
        </form>
        <div v-if="babies">
            <div v-for="baby in babies" :key="baby.id">
                <NavLink
                    :href="route('babies.journals.index', { baby: baby })"
                    >{{ baby.first_name }}</NavLink
                >
            </div>
        </div>
    </AuthenticatedLayout>
</template>
