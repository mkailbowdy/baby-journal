<script setup lang="ts">
import Journal from '@/Components/Journal.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import JournalForm from '@/Pages/Journals/JournalForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps(['journals']);
</script>
<template>
    <Head title="Journals" />
    <AuthenticatedLayout>
        <div class="mx-auto max-w-2xl p-4 sm:p-6 lg:p-8">
            <div>
                <JournalForm />
            </div>

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

