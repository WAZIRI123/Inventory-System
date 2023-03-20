<template>
  <button :type="type"
    :class="`inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white  tracking-widest ${bgColorClass} hover:${bgColorHoverClass} active:${bgColorActiveClass} focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm`
    "
    :disabled="props.disabled"
  >
    <slot></slot>
  </button>
</template>

<script setup>
const props = defineProps({
  disabled: {
    type: Boolean,
    default: false,
  },
  bgColor: {
    type: String,
    default: 'bg-gray-800',
  },
  type:{
    type:String,
    default:'button'
  },
  bgColorHoverClass: {
    type: String,
    default: 'bg-gray-700',
  },
  bgColorActiveClass: {
    type: String,
    default: 'bg-gray-900',
  },
});

const bgColorClass = `${props.bgColor}`;
</script>
