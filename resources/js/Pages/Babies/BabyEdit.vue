<script setup lang="ts">
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useFlashMessage } from '@/Composables/useFlashMessage';
import { MessageType } from '@/types/MessageType';
const props = defineProps(['baby', 'form']);
const emit = defineEmits(['submitted', 'cancelled', 'deleted']);

const localForm = props.form;

const { message, messageType, showMessage, messageDescription, messageClass } =
    useFlashMessage();

function editFormSubmitted() {
    localForm.patch(route('babies.update', props.baby));
    emit('submitted');
}
</script>

<template>
    <Transition>
        <div v-if="message" class="text-center" :class="messageClass">
            {{ messageDescription(messageType as MessageType) }}
        </div>
    </Transition>
    <div class="mx-auto mt-8 max-w-7xl px-4 pb-8 sm:px-6 lg:px-8">
        <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
        <div class="mx-auto max-w-3xl">
            <form @submit.prevent="editFormSubmitted()" class="space-y-6">
                <!-- First Name -->
                <div class="space-y-2">
                    <label for="firstName" class="block text-sm font-medium">
                        First Name
                    </label>
                    <input
                        type="text"
                        id="firstName"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                        v-model="localForm.first_name"
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
                        v-model="localForm.birthday"
                    />
                </div>

                <!-- Allergies -->
                <div class="space-y-2">
                    <label for="allergies" class="block text-sm font-medium">
                        Allergies
                    </label>
                    <textarea
                        id="allergies"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        rows="3"
                        v-model="localForm.allergies"
                    ></textarea>
                </div>

                <!-- Vaccinations -->
                <div class="space-y-2">
                    <label for="vaccinations" class="block text-sm font-medium">
                        Vaccinations
                    </label>
                    <textarea
                        id="vaccinations"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        rows="3"
                        v-model="localForm.vaccinations"
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
                        v-model="localForm.likes"
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
                        v-model="localForm.dislikes"
                    ></textarea>
                </div>
                <div class="flex justify-center">
                    <PrimaryButton
                        type="submit"
                        class="rounded-md bg-emerald-500 px-6 py-3 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        <span class="text-lg">Submit</span>
                    </PrimaryButton>
                    <SecondaryButton @click.prevent="emit('cancelled')"
                        >Cancel</SecondaryButton
                    >
                    <PrimaryButton
                        class="bg-red-500"
                        @click.prevent="emit('deleted')"
                        >Delete</PrimaryButton
                    >
                </div>
            </form>
        </div>
    </div>
</template>
