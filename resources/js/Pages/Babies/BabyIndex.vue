<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';

defineProps(['babies']);
function saveToDatabase() {
    console.log('submit button clicked');
    // Inertia's form helpers refreshes the props
    form.post(route('babies.store'), {
        onSuccess: () => {
            console.log('success');
            form.reset();
        },
        onError: (errors) => {
            console.log(':error' + errors);
        },
    });
}
const form = useForm({
    first_name: '',
});
</script>
<template>
    <AuthenticatedLayout>
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold text-gray-900">Users</h1>
                    <p class="mt-2 text-sm text-gray-700">
                        A list of all the users in your account including their
                        name, title, email and role.
                    </p>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <button
                        type="button"
                        class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >
                        Add user
                    </button>
                </div>
            </div>
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div
                        class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8"
                    >
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                                <tr>
                                    <th
                                        scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0"
                                    >
                                        Name
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                    >
                                        Birthday
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                    >
                                        Allergies
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                    >
                                        Journal
                                    </th>
                                    <th
                                        scope="col"
                                        class="relative py-3.5 pl-3 pr-4 sm:pr-0"
                                    >
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr v-for="baby in babies" :key="baby.id">
                                    <td
                                        class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0"
                                    >
                                        {{ baby.first_name }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                    >
                                        sdafsdf
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                    >
                                        dsfadsfsaf
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                    >
                                        <a
                                            :href="
                                                route(
                                                    'babies.journals.index',
                                                    baby,
                                                )
                                            "
                                        >
                                            <svg
                                                fill="#000000"
                                                height="16px"
                                                width="16px"
                                                version="1.1"
                                                id="Layer_1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                viewBox="0 0 330 330"
                                                xml:space="preserve"
                                            >
                                                <g
                                                    id="SVGRepo_bgCarrier"
                                                    stroke-width="0"
                                                ></g>
                                                <g
                                                    id="SVGRepo_tracerCarrier"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                ></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path
                                                        id="XMLID_222_"
                                                        d="M250.606,154.389l-150-149.996c-5.857-5.858-15.355-5.858-21.213,0.001 c-5.857,5.858-5.857,15.355,0.001,21.213l139.393,139.39L79.393,304.394c-5.857,5.858-5.857,15.355,0.001,21.213 C82.322,328.536,86.161,330,90,330s7.678-1.464,10.607-4.394l149.999-150.004c2.814-2.813,4.394-6.628,4.394-10.606 C255,161.018,253.42,157.202,250.606,154.389z"
                                                    ></path>
                                                </g>
                                            </svg>
                                        </a>
                                    </td>
                                    <!--                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">-->
                                    <!--                                    <a href="#" class="text-indigo-600 hover:text-indigo-900"-->
                                    <!--                                    >Edit<span class="sr-only">, {{ person.name }}</span></a-->
                                    <!--                                    >-->
                                    <!--                                </td>-->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--        <template #header>-->
        <!--            <Head title="Babies" />-->
        <!--            <h1 class="text-xl font-semibold leading-tight text-gray-800">-->
        <!--                Whose journal would you like to open?-->
        <!--            </h1>-->
        <!--        </template>-->
        <!--        <div v-if="babies" class="flex w-full flex-col">-->
        <!--            <div v-for="baby in babies" :key="baby.id" class="bg-emerald-300">-->
        <!--                <NavLink-->
        <!--                    class="w-full"-->
        <!--                    :href="route('babies.journals.index', { baby: baby })"-->
        <!--                    ><p class="text-4xl">{{ baby.first_name }}</p></NavLink-->
        <!--                >-->
        <!--            </div>-->
        <!--        </div>-->
        <!--        <div>-->
        <!--            <form @submit.prevent="saveToDatabase()">-->
        <!--                <BaseInput-->
        <!--                    label="Add another child?"-->
        <!--                    type="text"-->
        <!--                    v-model="form.first_name"-->
        <!--                />-->
        <!--                <div v-if="form.errors.first_name" class="error">-->
        <!--                    {{ form.errors.first_name }}-->
        <!--                </div>-->
        <!--                <button>Submit</button>-->
        <!--            </form>-->
        <!--        </div>-->
    </AuthenticatedLayout>
</template>
