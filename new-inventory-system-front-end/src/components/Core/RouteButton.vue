<template>
    <router-link :to="{ name: 'employee' }" :class="classes" ref="buttonRef">
      {{ label }}
    </router-link>
  </template>
  
  <script setup>
   const props = defineProps({
  disabled: {
    type: Boolean,
    default: false,
  },
  to: {
        type: [String],
        required: true
      },

      label: {
        type: String,
        default: 'Cancel'
      },
      classes: {
        type: String,
        default: 'mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm'
      }
});
function focus() {
        this.$refs.buttonRef.focus();
      }

  </script>
  