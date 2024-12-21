<script setup lang="ts">
import Dropdown from '@/Components/Dropdown.vue';
import JournalEditForm from '@/Pages/Journals/JournalEditForm.vue';
import { Journal } from '@/types/Journal';
import { MessageType } from '@/types/MessageType';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { ref } from 'vue';

const editing = ref(false);
const props = defineProps(['journal']);
const emit = defineEmits(['journalUpdated', 'journalDeleted']);

dayjs.extend(relativeTime);
function updateJournal(journal: Journal) {
    editing.value = false;
    emit('journalUpdated', journal);
}
function deleteJournal() {
    editing.value = false;
    emit('journalDeleted', MessageType.DELETED);
}
</script>

<template>
    <div class="flex space-x-2 p-6">
        <div class="flex-1">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-2xl font-bold">
                        {{
                            new Date(journal.date).toLocaleString('en-US', {
                                month: 'short',
                                day: 'numeric',
                                year: 'numeric',
                            })
                        }}
                    </span>
                    <small class="ml-4 text-gray-500">{{
                        dayjs(journal.date).fromNow()
                    }}</small>
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
                            class="block w-full py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                            @click="editing = true"
                        >
                            Edit
                        </button>
                    </template>
                </Dropdown>
            </div>
            <div v-if="!editing">
                <img
                    v-if="journal.image"
                    :src="`storage/${journal.image}`"
                    alt="journal image"
                />
                <div class="mt-4">
                    <div>Height: {{ journal.height }}cm</div>
                    <div>Weight: {{ journal.weight }}g</div>
                </div>
                <p class="mt-4 text-2xl text-gray-900">{{ journal.entry }}</p>
            </div>
            <div v-else class="mt-4">
                <JournalEditForm
                    :journal="props.journal"
                    @journal-updated="updateJournal"
                    @journal-deleted="deleteJournal"
                    @journal-cancelled="editing = false"
                />
            </div>
        </div>
    </div>
</template>
