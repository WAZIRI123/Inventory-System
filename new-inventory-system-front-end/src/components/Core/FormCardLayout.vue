<template>
    <div class="flex justify-center ">
    <div class="bg-white p-4 rounded-lg shadow-xl py-8 mt-12 sm:mx-8 w-full">
        <!-- start:: Multiple Columns -->
        <div>
            <h4 class="text-xl capitalize">{{title}}</h4>
           <slot></slot>
        </div>
    </div>
    </div>
</template>

<script setup>
const {title} = defineProps({
  title: String
})
</script>


