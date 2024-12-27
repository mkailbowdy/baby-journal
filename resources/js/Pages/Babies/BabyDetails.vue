<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps(['baby']);
</script>

<template>
    <AuthenticatedLayout>
        <p>{{ baby.first_name }}</p>
        <p>{{ baby.birthday }}</p>
    </AuthenticatedLayout>
</template>
