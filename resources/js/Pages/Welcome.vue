<script setup lang="ts">
import NavBar from '@/Components/NavBar.vue';
import { Head } from '@inertiajs/vue3';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
    laravelVersion: string;
    phpVersion: string;
}>();
</script>

<template>
    <Head title="Welcome" />
    <header>
        <NavBar />
    </header>
</template>
