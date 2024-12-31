<script setup lang="ts">
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useFlashMessage } from '@/Composables/useFlashMessage';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BabyEdit from '@/Pages/Babies/BabyEdit.vue';
import { MessageType } from '@/types/MessageType';
import { useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
const props = defineProps(['baby']);
const editing = ref(false);
const form = useForm({
    first_name: props.baby.first_name,
    birthday: props.baby.birthday,
    allergies: props.baby.allergies,
    vaccinations: props.baby.vaccinations,
    likes: props.baby.likes,
    dislikes: props.baby.dislikes,
});

const { message, messageType, showMessage, messageDescription, messageClass } =
    useFlashMessage();

const editFormSubmitted = () => {
    editing.value = !editing.value;
    showMessage(MessageType.SUCCESS);
};
function deleteBaby(localBaby) {
    // Inertia's form helpers refreshes the props
    form.delete(
        route('babies.destroy', {
            baby: localBaby,
        }),
        {
            onSuccess: () => {
                route('babies.index');
            },
        },
    );
}
</script>

<template>
    <AuthenticatedLayout>
        <Transition>
            <div v-if="message" class="text-center" :class="messageClass">
                {{ messageDescription(messageType as MessageType) }}
            </div>
        </Transition>
        <div v-if="!editing">
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
                            <SecondaryButton @click="editing = !editing">
                                Edit
                            </SecondaryButton>

                            <!--                        <NavLink :href="route('babies.edit', baby)" class="hover:border-opacity-0"-->
                            <!--                            ><div class="inline-block px-3 py-2 rounded text-white bg-gray-500 text-md">Edit</div></NavLink-->
                            <!--                        >-->
                        </div>
                        <div class="border-t border-gray-100">
                            <dl class="divide-y divide-gray-100">
                                <div
                                    class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                                >
                                    <dt
                                        class="text-sm font-medium text-gray-900"
                                    >
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
                                    <dt
                                        class="text-sm font-medium text-gray-900"
                                    >
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
                                    <dt
                                        class="text-sm font-medium text-gray-900"
                                    >
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
                                    <dt
                                        class="text-sm font-medium text-gray-900"
                                    >
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
                                    <dt
                                        class="text-sm font-medium text-gray-900"
                                    >
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
        </div>
        <div v-else>
            <BabyEdit
                :baby="baby"
                :form="form"
                @cancelled="editing = !editing"
                @submitted="editFormSubmitted"
                @deleted="deleteBaby(props.baby)"
            />
        </div>
        <div class="mt-4 flex justify-around">
            <Link
                class="inline-block pb-1 text-xl font-bold text-emerald-500 hover:border-b hover:border-b-emerald-400"
                :href="route('babies.journals.index', baby)"
                >Go To Journal
            </Link>
        </div>
    </AuthenticatedLayout>
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
