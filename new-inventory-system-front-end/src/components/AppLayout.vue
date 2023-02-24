<script setup>
import { RouterLink, RouterView } from "vue-router";
import NavBar from "./NavBar.vue";
import {computed, onMounted, ref} from "vue";

import SideBar from "./SideBar.vue";

const menuOpen=ref(false);

function toggleMenuOpened() {
        menuOpen.value = true;
    }
    function closeSidebar() {
        menuOpen.value = false
    }
</script>

<template>
<div class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden hidden"></div>
    <SideBar :menuOpen="menuOpen" @closeSideBar="closeSidebar"/>
<div class="lg:pl-64 w-full flex flex-col">
    <NavBar @toggle="toggleMenuOpened"/>
    <RouterView/>
</div>
</template>

<style scoped>

</style>
