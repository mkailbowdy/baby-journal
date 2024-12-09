<script setup lang="ts">
import NavLink from '@/Components/NavLink.vue';
import { ref } from 'vue';

// defineProps<{
//     canLogin?: boolean;
//     canRegister?: boolean;
// }>();

const open = ref<boolean>(false);

// I asked Claude AI to figure this out...
// Ask any AI the following: Can you break this down for me? I want to understand how it all works:

function toggleMenu(): void {
    open.value = !open.value;
}
</script>
<template>
    <div class="flex justify-end bg-indigo-800">
        <button @click.prevent="toggleMenu" class="static z-50">
            <svg
                width="50"
                height="50"
                viewBox="0 0 120 100"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <g id="rectangles">
                    <g id="crimsonGroup">
                        <rect
                            :class="open ? 'rotate-crimson1' : ''"
                            id="crimson1"
                            x="20"
                            y="45"
                            width="80"
                            height="10"
                        />
                        <rect
                            :class="{ 'rotate-crimson2': open }"
                            id="crimson2"
                            x="20"
                            y="45"
                            width="80"
                            height="10"
                        />
                    </g>
                    <g id="indigoGroup">
                        <rect
                            :class="open ? 'slide-indigo1' : ''"
                            id="indigo1"
                            x="20"
                            y="25"
                            width="80"
                            height="10"
                        />
                        <rect
                            :class="open ? 'slide-indigo2' : ''"
                            id="indigo2"
                            x="20"
                            y="65"
                            width="80"
                            height="10"
                        />
                    </g>
                </g>
            </svg>
        </button>
    </div>
    <Transition name="blur">
        <div
            v-if="open"
            class="fixed inset-0 bg-gray-400/10 backdrop-blur-sm transition-all duration-300 ease-in-out"
        ></div>
    </Transition>
    <Transition name="slide">
        <div v-if="open" class="fixed inset-0">
            <div @click="toggleMenu" class="fixed inset-0"></div>
            <nav class="fixed right-0 z-40 h-screen w-48 bg-indigo-500">
                <div class="z-30 mt-16">
                    <NavLink
                        :href="route('dashboard')"
                        :active="route().current('dashboard')"
                    >
                        Dashboard
                    </NavLink>
                    <NavLink
                        :href="route('journals.index')"
                        :active="route().current('journals.index')"
                    >
                        Journals
                    </NavLink>
                </div>
            </nav>
        </div>
    </Transition>
</template>

<style>
:root {
    --indigo-color: rgb(99 102 241);
    --crimson-color: #990000;
}

#indigoGroup {
    fill: var(--indigo-color);
}

#crimsonGroup {
    fill: var(--crimson-color);
}

#crimson1,
#crimson2 {
    transition: all 0.3s ease;
}

#indigo1,
#indigo2 {
    transition: all 0.3s ease;
}

.rotate-crimson1 {
    transform-origin: 60px 50px;
    transform: rotate(45deg);
}

.rotate-crimson2 {
    transform-origin: 60px 50px;
    transform: rotate(-45deg);
}

.slide-indigo1,
.slide-indigo2,
.slide-indigo1:hover,
.slide-indigo2:hover {
    transform: translateX(100px);
}

/*
  Enter and leave animations can use different
  durations and timing functions.
*/
.slide-enter-from {
    transform: translateX(100%);
    opacity: 0;
}

.slide-enter-active {
    transition: all 0.2s ease;
}

.slide-enter-to {
    transform: translateX(0);
    opacity: 1;
}

.slide-leave-from {
    transform: translateX(0);
    opacity: 1;
}

.slide-leave-active {
    transition: all 0.2s ease-in;
}

.slide-leave-to {
    transform: translateX(100%);
    opacity: 0;
}

/* Add these transition classes */
.blur-enter-from {
    opacity: 0;
    backdrop-filter: blur(0);
}

.blur-enter-active {
    transition: all 0.3s ease-out;
}

.blur-enter-to {
    opacity: 1;
    backdrop-filter: blur(4px);
}

.blur-leave-from {
    opacity: 1;
    backdrop-filter: blur(4px);
}

.blur-leave-active {
    transition: all 0.3s ease-in;
}

.blur-leave-to {
    opacity: 0;
    backdrop-filter: blur(0);
}
</style>
