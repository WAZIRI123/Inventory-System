<template>
    <button type="submit"
      :class="[
        'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150',
        $attrs.class
      ]"
      @click="$emit('click')"
      :disabled="disabled"
    >
      {{ $slots.default }}
    </button>
  </template>
  
  <script setup>
const props = defineProps({
    disabled: {
        type: Boolean,
        default: false,
      },
})
  </script>
  