<script setup lang="ts"></script>

<template>
    <div class="relative isolate overflow-hidden bg-white">
        <svg
            class="absolute inset-0 -z-10 size-full stroke-emerald-200 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]"
            aria-hidden="true"
        >
            <defs>
                <pattern
                    id="0787a7c5-978c-4f66-83c7-11c213f99cb7"
                    width="200"
                    height="200"
                    x="50%"
                    y="-1"
                    patternUnits="userSpaceOnUse"
                >
                    <path d="M.5 200V.5H200" fill="none" />
                </pattern>
            </defs>
            <rect
                width="100%"
                height="100%"
                stroke-width="0"
                fill="url(#0787a7c5-978c-4f66-83c7-11c213f99cb7)"
            />
        </svg>
        <div
            class="mx-auto max-w-7xl px-6 pb-24 pt-10 sm:pb-32 lg:flex lg:px-8 lg:py-40"
        >
            <div class="mx-auto max-w-2xl lg:mx-0 lg:shrink-0 lg:pt-8">
                <h1
                    class="mt-10 text-pretty text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl"
                >
                    Remember All Of Their Firsts
                </h1>
                <p
                    class="mt-8 text-pretty text-lg font-medium text-gray-500 sm:text-xl/8"
                >
                    Journal Every Precious Moment, from First Steps to First
                    Words.
                </p>
                <div class="mt-10 flex items-center gap-x-6">
                    <a
                        href="/register"
                        class="rounded-md bg-emerald-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600"
                        >Get started</a
                    >
                    <a href="#" class="text-sm/6 font-semibold text-gray-900"
                        >Learn more <span aria-hidden="true">→</span></a
                    >
                </div>
            </div>
            <div
                class="mx-auto mt-16 flex max-w-2xl sm:mt-24 lg:ml-10 lg:mr-0 lg:mt-0 lg:max-w-none lg:flex-none xl:ml-32"
            >
                <div class="max-w-3xl flex-none sm:max-w-5xl lg:max-w-none">
                    <div
                        class="-m-2 rounded-xl bg-gray-900/5 p-2 ring-1 ring-inset ring-gray-900/10 lg:-m-4 lg:rounded-2xl lg:p-4"
                    >
                        <img
                            src="/images/hero_pic.png"
                            alt="App screenshot"
                            class="rounded-md shadow-2xl ring-1 ring-gray-900/10"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
