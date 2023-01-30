<template>

         <!-- start::Menu link -->
          <router-link :to="parameter ? { path: `${path}`, params: { userId:parameter } } : { path: `${path}` }"  class="flex items-center text-gray-400 px-6 py-3 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200"> 
                <slot></slot>
                <span class="ml-3 transition duration-200" :class="linkHover ? 'text-gray-100' : ''">
                    {{name}}
                </span></router-link>

            <!-- end::Menu link -->
</template>

<script setup>
import MessageIcon from '../SvgsIcons/MessageIcon.vue';

  const emit = defineProps(['path','parameter','name'])

</script>