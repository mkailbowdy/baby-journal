<script setup lang="ts">
// useForm( initializes a reactive object)
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useFlashMessage } from '@/Composables/useFlashMessage';
import { Journal } from '@/types/Journal';
import { MessageType } from '@/types/MessageType';
import { useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const emit = defineEmits(['formSubmitted', 'closeForm']);
const props = defineProps(['journal']);
const imagePreview = ref<string | null>(null);
const imageError = ref<string | null>(null);
const localJournal = computed(() => {
    if (props.journal) {
        return props.journal;
    } else {
        return {
            date: '',
            height: 0,
            weight: 0,
            entry: '',
        };
    }
});

const form = useForm<Journal>({
    date: new Date().toISOString().split('T')[0],
    height: localJournal.value.height,
    weight: localJournal.value.weight,
    entry: '',
    image: null,
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
    // Inertia's form helpers refreshes the props
    form.post(route('journals.store'), {
        onSuccess: () => {
            form.reset();
            emit('formSubmitted');
            emit('closeForm');
            showMessage(MessageType.SUCCESS); // same as saying showMessage('success')
        },
        onError: () => {
            showMessage(MessageType.ERROR); // same as saying showMessage('error')
        },
    });
}

function handleFileInput($event: Event): void {
    const target = $event.target as HTMLInputElement;
    if (target && target.files) {
        const file = target.files[0];
        form.image = file;

        // Create a FileReader to generate a preview
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target?.result as string;
        };

        // when readAsDataUrl(file) is finished reading the file, the reader.onload() above will fire and set the imagePreview.value string
        reader.readAsDataURL(file);
    }
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
                    <InputError :message="form.errors.date" class="mt-2" />
                </div>
                <div class="flex flex-col">
                    <label for="height">Height <small>cm</small></label>
                    <input
                        v-model="form.height"
                        type="number"
                        name="height"
                        id="height"
                        min="1"
                        class="block w-32 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    />
                    <!--                    <InputError :message="form.errors.height" class="mt-2" />-->
                </div>

                <div class="flex flex-col">
                    <label for="weight">Weight <small>kg</small></label>
                    <input
                        v-model="form.weight"
                        type="number"
                        name="weight"
                        id="weight"
                        min="1"
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
                <InputError :message="form.errors.entry" class="mt-2" />
                <input
                    type="file"
                    id="image"
                    name="image"
                    accept="image/png, image/jpeg"
                    @input="handleFileInput"
                />
                <p v-if="imageError" class="text-red-500">{{ imageError }}</p>
                <img
                    v-if="imagePreview"
                    :src="imagePreview"
                    class="mt-4 max-w-xs rounded-lg shadow-md"
                    alt="journal image"
                />
                <progress
                    v-if="form.progress"
                    :value="form.progress.percentage"
                    max="100"
                >
                    {{ form.progress.percentage }}%
                </progress>
            </div>
        </div>

        <PrimaryButton class="mb-4 mt-4 bg-teal-500" :disabled="form.processing"
            >Submit</PrimaryButton
        >
        <SecondaryButton @click="emit('closeForm')" class="mb-4 ml-4 mt-4"
            >Cancel
        </SecondaryButton>
    </form>
    <Transition>
        <div v-if="message" :class="messageClass">
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
