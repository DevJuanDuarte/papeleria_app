<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center px-4 py-1.5 bg-white border border-gray-300 rounded-md text-sm font-medium leading-5 text-gray-700 tracking-widest shadow-sm hover:bg-gray-200"
    >
        <slot />
    </button>
</template>
