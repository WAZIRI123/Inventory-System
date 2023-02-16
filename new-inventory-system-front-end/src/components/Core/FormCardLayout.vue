<template>
    <div class="bg-white  p-4 grid grid-cols-1 gap-8 rounded-lg shadow-xl py-8 mt-12">
        <!-- start:: Multiple Columns -->
        <div>
            <h4 class="text-xl capitalize">{{title}}</h4>
           <slot></slot>
        </div>
    </div>
</template>

<script setup>
const {title} = defineProps({
  title: String
})
</script>


