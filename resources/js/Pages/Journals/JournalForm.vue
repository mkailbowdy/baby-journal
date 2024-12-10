<script setup lang="ts">
// useForm( initializes a reactive object)
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useFlashMessage } from '@/Composables/useFlashMessage';
import { MessageType } from '@/Enums/MessageType';
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const form = useForm({
    date: '',
    height: 0,
    weight: 0,
    entry: '',
});
const messageClass = computed(() => {
    switch (messageType.value) {
        case MessageType.SUCCESS:
            return 'bg-green-500';
        case MessageType.ERROR:
            return 'bg-red-500';
        default:
            return '';
    }
});

// The useFlashMessage() function returns an object, and the destructuring syntax
// extracts the message, messageType, and showMessage properties into local variables with the same names
const { message, messageType, showMessage } = useFlashMessage();
//Without destructuring, you'd need to write:
// const flashMessage = useFlashMessage();
// const message = flashMessage.message;
// const messageType = flashMessage.messageType;
// const showMessage = flashMessage.showMessage;

function saveToDatabase() {
    form.post(route('journals.store'), {
        onSuccess: () => {
            form.reset();
            showMessage(MessageType.SUCCESS); // same as saying showMessage('success')
        },
        onError: () => {
            showMessage(MessageType.ERROR); // same as saying showMessage('error')
        },
    });
}
</script>
<template>
    <form @submit.prevent="saveToDatabase()">
        <div class="flex flex-col gap-4">
            <div class="flex flex-row items-center justify-between">
                <div class="flex flex-col">
                    <label for="date">Journal Date</label>
                    <input
                        v-model="form.date"
                        type="date"
                        name="date"
                        id="date"
                        class="block rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    />
                </div>
                <div class="flex flex-col">
                    <label for="height">Height <small>cm</small></label>
                    <input
                        v-model="form.height"
                        type="number"
                        name="height"
                        id="height"
                        class="block w-32 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    />
                </div>

                <div class="flex flex-col">
                    <label for="weight">Weight <small>kg</small></label>
                    <input
                        v-model="form.weight"
                        type="number"
                        name="weight"
                        id="weight"
                        class="block w-32 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    />
                </div>
            </div>

            <div>
                <label for="entry">Entry</label>
                <textarea
                    name="entry"
                    id="entry"
                    v-model="form.entry"
                    placeholder="What did your child do today?"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                ></textarea>
            </div>
        </div>

        <InputError :message="form.errors.entry" class="mt-2" />
        <PrimaryButton class="mb-4 mt-4 bg-teal-500">Submit </PrimaryButton>
    </form>
    <Transition>
        <div v-if="message" class="" :class="messageClass">
            {{
                messageType === MessageType.SUCCESS
                    ? 'Journal added!'
                    : 'An error occurred'
            }}
        </div>
    </Transition>
</template>

<style>
/* we will explain what these classes do next! */
.v-enter-active,
.v-leave-active {
    transition: all 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
    transform: translateY(-20%);
}
</style>
