<template>

    <ul class="text-sm text-red-600 dark:text-red-400 space-y-1" v-if="messages">

            <li >{{ messages }}</li>

    </ul>


</template>

<script setup>

const { messages } = defineProps({
    messages: String,
})
</script>