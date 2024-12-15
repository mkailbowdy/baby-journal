<script setup lang="ts">
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { ref } from 'vue';

dayjs.extend(relativeTime);
const props = defineProps(['journal']);
const emit = defineEmits(['editFormSubmitted', 'journalDeleted']);
const form = useForm({
    entry: props.journal.entry,
    date: props.journal.date,
    height: props.journal.height,
    weight: props.journal.weight,
});

const editing = ref(false);

function deleteJournal(journalId: number) {
    // Inertia's form helpers refreshes the props
    form.delete(route('journals.destroy', journalId), {
        onSuccess: () => {
            form.reset();
            emit('journalDeleted');
        },
    });
}
</script>

<template>
    <div class="flex space-x-2 p-6">
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
                            class="block w-full py-2 text-center text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                            @click="editing = true"
                        >
                            Edit
                        </button>
                        <DropdownLink
                            as="button"
                            :href="route('journals.destroy', journal.id)"
                            @click.prevent="deleteJournal(journal.id)"
                        >
                            Delete
                        </DropdownLink>
                    </template>
                </Dropdown>
            </div>

            <form
                v-if="editing"
                @submit.prevent="
                    form.put(route('journals.update', journal.id), {
                        onSuccess: () => {
                            editing = false;
                            emit('editFormSubmitted', journal.id);
                        },
                    })
                "
            >
                <div class="mb-4">
                    <img
                        alt="profile picture"
                        :src="`storage/${journal.image}`"
                    />
                </div>
                <input v-model="form.date" type="date" />
                <input v-model="form.height" type="number" />
                <input v-model="form.weight" type="number" />
                <textarea
                    v-model="form.entry"
                    class="mt-4 w-full rounded-md border-gray-300 text-gray-900 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                ></textarea>
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
                <div class="mb-8">
                    <img
                        :src="`storage/${journal.image}`"
                        alt="journal image"
                    />
                </div>
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
