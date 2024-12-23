<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';

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
        <h1>hello</h1>
        <form @submit.prevent="saveToDatabase()">
            <input type="text" v-model="form.first_name" />
            <div v-if="form.errors.first_name" class="error">
                {{ form.errors.first_name }}
            </div>
            <button>Submit</button>
        </form>
        <div v-if="babies">
            <div v-for="baby in babies" :key="baby.id">
                {{ baby.first_name }}
            </div>
        </div>
    </AuthenticatedLayout>
</template>
