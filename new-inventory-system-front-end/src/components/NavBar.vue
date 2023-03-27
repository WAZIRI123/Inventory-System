
<template>

<div class="flex flex-col">
        <header class="flex justify-between items-center h-16 py-4 px-6 bg-white">
            <!-- start::Mobile menu button -->
            <div class="flex items-center" @click="setOpenButton()">
                <button @click="$emit('toggle')"
                ref="openButtonRef"
                    class="openButton text-gray-500 hover:text-primary focus:outline-none lg:hidden transition duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7"></path>
                    </svg>
                </button>
            </div>
            <!-- end::Mobile menu button -->
        
        </header>
    </div>
</template>

<script setup>
import store from "../store";
import router from "../router";
import {computed, onMounted,onUnmounted, ref} from "vue";
const sidebar = document.querySelector('.opdeButton')
const emit = defineEmits(['OpenButton']);
const openButtonRef=ref(null)
function logout() {
    store.dispatch("logout").then(() => {
        router.push({
          name: "login",
        });
      });
    }
    function setOpenButton(){
       
     emit('OpenButton',openButtonRef.value)
       
    }
</script>

<style scoped>

</style>

