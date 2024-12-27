<script setup lang="ts">
import NavLink from '@/Components/NavLink.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
defineProps(['baby']);
</script>

<template>
    <AuthenticatedLayout>
        <div class="mx-auto mt-8 max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
            <div class="mx-auto max-w-3xl">
                <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-6 sm:px-6">
                        <h3 class="text-4xl font-semibold text-gray-900">
                            {{ baby.first_name }}
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm/6 text-gray-500">
                            Profile Section
                        </p>
                        <NavLink :href="route('babies.edit', baby)" class="hover:border-opacity-0"
                            ><div class="inline-block px-3 py-2 rounded text-white bg-gray-500 text-md">Edit</div></NavLink
                        >
                    </div>
                    <div class="border-t border-gray-100">
                        <dl class="divide-y divide-gray-100">
                            <div
                                class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                            >
                                <dt class="text-sm font-medium text-gray-900">
                                    Birthday
                                </dt>
                                <dd
                                    class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0"
                                >
                                    {{ baby.birthday }}
                                </dd>
                            </div>
                            <div
                                class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                            >
                                <dt class="text-sm font-medium text-gray-900">
                                    Allergies
                                </dt>
                                <dd
                                    class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0"
                                >
                                    {{ baby.allergies }}
                                </dd>
                            </div>
                            <div
                                class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                            >
                                <dt class="text-sm font-medium text-gray-900">
                                    Vaccinations
                                </dt>
                                <dd
                                    class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0"
                                >
                                    {{ baby.vaccinations }}
                                </dd>
                            </div>
                            <div
                                class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                            >
                                <dt class="text-sm font-medium text-gray-900">
                                    Likes
                                </dt>
                                <dd
                                    class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0"
                                >
                                    {{ baby.likes }}
                                </dd>
                            </div>
                            <div
                                class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                            >
                                <dt class="text-sm font-medium text-gray-900">
                                    Dislikes
                                </dt>
                                <dd
                                    class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0"
                                >
                                    {{ baby.dislikes }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
