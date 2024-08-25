<template>
    <button :type="type" class="rounded-lg border border-transparent bg-yellow-500 px-4 py-1.5 text-center text-sm font-medium leading-5 text-white transition-colors duration-150 hover:bg-yellow-600 focus:outline-none focus:ring active:bg-yellow-500">
      <slot/>
    </button>
  </template>

  <script setup>
  defineProps({
      type: {
          type: String,
          default: 'submit',
      },
  });
  </script>
