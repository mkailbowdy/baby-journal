<script setup lang="ts">
const props = defineProps(['label']);
const model = defineModel();
</script>
<template>
    <label :for="props.label">{{ props.label }}</label>
    <input
        v-model="model"
        v-bind="$attrs"
        class="block rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
    />
</template>
