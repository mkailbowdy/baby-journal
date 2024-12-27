<script setup lang="ts">
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';
const props = defineProps(['baby']);

const form = useForm({
    first_name: props.baby.first_name,
    birthday: props.baby.birthday,
    allergies: props.baby.allergies,
    vaccinations: props.baby.vaccinations,
    likes: props.baby.likes,
    dislikes: props.baby.dislikes,
});
</script>

<template>
    <AuthenticatedLayout>
        <div class="mx-auto mt-8 max-w-7xl px-4 pb-8 sm:px-6 lg:px-8">
            <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
            <div class="mx-auto max-w-3xl">
                <form
                    @submit.prevent="
                        form.patch(route('babies.update', props.baby))
                    "
                    class="space-y-6"
                >
                    <!-- First Name -->
                    <div class="space-y-2">
                        <label
                            for="firstName"
                            class="block text-sm font-medium"
                        >
                            First Name
                        </label>
                        <input
                            type="text"
                            id="firstName"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                            v-model="form.first_name"
                        />
                    </div>

                    <!-- Birthday -->
                    <div class="space-y-2">
                        <label for="birthday" class="block text-sm font-medium">
                            Birthday
                        </label>
                        <input
                            type="date"
                            id="birthday"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                            v-model="form.birthday"
                        />
                    </div>

                    <!-- Allergies -->
                    <div class="space-y-2">
                        <label
                            for="allergies"
                            class="block text-sm font-medium"
                        >
                            Allergies
                        </label>
                        <textarea
                            id="allergies"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            rows="3"
                            v-model="form.allergies"
                        ></textarea>
                    </div>

                    <!-- Vaccinations -->
                    <div class="space-y-2">
                        <label
                            for="vaccinations"
                            class="block text-sm font-medium"
                        >
                            Vaccinations
                        </label>
                        <textarea
                            id="vaccinations"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            rows="3"
                            v-model="form.vaccinations"
                        ></textarea>
                    </div>

                    <!-- Likes -->
                    <div class="space-y-2">
                        <label for="likes" class="block text-sm font-medium">
                            Likes
                        </label>
                        <textarea
                            id="likes"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            rows="3"
                            v-model="form.likes"
                        ></textarea>
                    </div>

                    <!-- Dislikes -->
                    <div class="space-y-2">
                        <label for="dislikes" class="block text-sm font-medium">
                            Dislikes
                        </label>
                        <textarea
                            id="dislikes"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            rows="3"
                            v-model="form.dislikes"
                        ></textarea>
                    </div>
                    <div class="flex justify-center">
                        <PrimaryButton
                            type="submit"
                            class="rounded-md bg-emerald-500 px-6 py-3 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        >
                            <span class="text-lg">Submit</span>
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
