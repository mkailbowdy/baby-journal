<script setup lang="ts">
import Dropdown from '@/Components/Dropdown.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { ref } from 'vue';

dayjs.extend(relativeTime);
const props = defineProps(['journal']);

const form = useForm({
    entry: props.journal.entry,
    date: props.journal.date,
    height: props.journal.height,
    weight: props.journal.weight,
});

const editing = ref(false);
</script>

<template>
    <div class="flex space-x-2 p-6">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6 -scale-x-100 text-gray-600"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
            />
        </svg>
        <div class="flex-1">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-gray-800">{{ journal.user.name }}</span>
                    <small class="ml-2 text-sm text-gray-600">{{
                        new Date(journal.date).toLocaleString('en-US', {
                            month: 'short',
                            day: 'numeric',
                            year: 'numeric',
                        })
                    }}</small>
                    <small class="ml-2 text-sm text-gray-600">{{
                        dayjs(journal.date).fromNow()
                    }}</small>
                    <!--                    <small v-if="journal.created_at !== journal.updated_at">&middot; edited</small>-->
                </div>
                <Dropdown v-if="journal.user.id === $page.props.auth.user.id">
                    <template #trigger>
                        <button>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 text-gray-400"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"
                                />
                            </svg>
                        </button>
                    </template>
                    <template #content>
                        <button
                            class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100"
                            @click="editing = true"
                        >
                            Edit
                        </button>
                    </template>
                </Dropdown>
            </div>

            <form
                v-if="editing"
                @submit.prevent="
                    form.put(route('journals.update', journal.id), {
                        onSuccess: () => (editing = false),
                    })
                "
            >
                <textarea
                    v-model="form.entry"
                    class="mt-4 w-full rounded-md border-gray-300 text-gray-900 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                ></textarea>
                <input v-model="form.date" type="date" />
                <input v-model="form.height" type="number" />
                <input v-model="form.weight" type="number" />
                <InputError :message="form.errors.entry" class="mt-2" />
                <div class="space-x-2">
                    <PrimaryButton class="mt-4">Save</PrimaryButton>
                    <button
                        class="mt-4"
                        @click="
                            editing = false;
                            form.reset();
                            form.clearErrors();
                        "
                    >
                        Cancel
                    </button>
                </div>
            </form>
            <div v-else>
                <div>
                    <small class="mt-4 text-lg text-gray-900"
                        >Height: {{ journal.height }}cm</small
                    ><br />
                    <small class="mt-4 text-lg text-gray-900"
                        >Weight: {{ journal.weight }}g</small
                    >
                </div>

                <p class="mt-4 text-lg text-gray-900">{{ journal.entry }}</p>
            </div>
        </div>
    </div>
</template>
