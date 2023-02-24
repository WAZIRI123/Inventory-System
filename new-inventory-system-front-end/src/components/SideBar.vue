<template>
    <aside :class="props.menuOpen ? 'translate-x-0 ease-out open' : '-translate-x-full ease-in'"
        class=" sidebar fixed z-30 inset-y-0 left-0 w-64 transition duration-300 bg-secondary overflow-y-auto lg:translate-x-0 lg:inset-0 custom-scrollbar translate-x-0 ease-out">
        <!-- start::Logo -->
        <div class="flex items-center justify-center bg-black bg-opacity-30 h-16">
            <h1 class="text-gray-100 text-lg font-bold uppercase tracking-widest">
                Inventory System
            </h1>
        </div>
        <button v-if="props.menuOpen" @click="$emit('closeSideBar')" class=" bg-red-600 absolute top-0 right-0 m-0 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-100 hover:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
          
        <!-- end::Logo -->

        <!-- start::Navigation -->
        <nav class="py-10 custom-scrollbar">
            <!-- start::Menu link -->
            <SingleSideLink title="dashboard" name="dashboard" :class="{'bg-black bg-opacity-30':isActiveLink('dashboard')}">
                <HomeIcon />
            </SingleSideLink>
            <!-- end::Menu link -->

            <p class="text-xs text-gray-600 mt-10 mb-2 px-6 uppercase">Apps</p>

            <!-- start::Menu link -->
            <div x-data="{ linkHover: false, linkActive: false }">

                <!-- start::Submenu -->
                <ul x-show="linkActive" x-collapse.duration.300ms="" class="text-gray-400"
                    style="overflow: hidden; height: 0px;">
                    <!-- start::Submenu link -->
                    <li
                        class="pl-10 pr-6 py-2 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200 hover:text-gray-100">
                        <a href="./pages/email/inbox.html" class="flex items-center">
                            <span class="mr-2 text-sm">•</span>
                            <span class="overflow-ellipsis">Inbox</span>
                        </a>
                    </li>
                    <!-- end::Submenu link -->

                    <!-- start::Submenu link -->
                    <li
                        class="pl-10 pr-6 py-2 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200 hover:text-gray-100">
                        <a href="./pages/email/viewMessage.html" class="flex items-center">
                            <span class="mr-2 text-sm">•</span>
                            <span class="overflow-ellipsis">LogOut</span>
                        </a>
                    </li>
                    <!-- end::Submenu link -->

                    <!-- start::Submenu link -->
                    <li
                        class="pl-10 pr-6 py-2 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200 hover:text-gray-100">
                        <a href="./pages/email/newMessage.html" class="flex items-center">
                            <span class="mr-2 text-sm">•</span>
                            <span class="overflow-ellipsis">Compose</span>
                        </a>
                    </li>
                    <!-- end::Submenu link -->
                </ul>
                <!-- end::Submenu -->
            </div>
            <!-- end::Menu link -->

            <!-- start::Menu link -->
            <div x-data="{ linkHover: false, linkActive: false }">
                <div @mouseover="linkHover = true" @mouseleave="linkHover = false" @click="linkActive = !linkActive"
                    class="flex items-center justify-between text-gray-400 hover:text-gray-100 px-6 py-3 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200"
                    :class="linkActive ? 'bg-black bg-opacity-30 text-gray-100' : ''">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition duration-200"
                            :class="linkHover || linkActive ? 'text-gray-100' : ''" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <span class="ml-3">E-Commerce</span>
                    </div>
                    <svg class="w-3 h-3 transition duration-300" :class="linkActive ? 'rotate-90' : ''" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
                <!-- start::Submenu -->
                <ul x-show="linkActive" x-collapse.duration.300ms="" class="text-gray-400"
                    style="overflow: hidden; height: 0px;">
                    <!-- start::Submenu link -->
                    <li
                        class="pl-10 pr-6 py-2 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200 hover:text-gray-100">
                        <a href="./pages/ecommerce/products.html" class="flex items-center">
                            <span class="mr-2 text-sm">•</span>
                            <span class="overflow-ellipsis">Products</span>
                        </a>
                    </li>
                    <!-- end::Submenu link -->

                    <!-- start::Submenu link -->
                    <li
                        class="pl-10 pr-6 py-2 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200 hover:text-gray-100">
                        <a href="./pages/ecommerce/productDetails.html" class="flex items-center">
                            <span class="mr-2 text-sm">•</span>
                            <span class="overflow-ellipsis">Product Details</span>
                        </a>
                    </li>
                    <!-- end::Submenu link -->

                    <!-- start::Submenu link -->
                    <li
                        class="pl-10 pr-6 py-2 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200 hover:text-gray-100">
                        <a href="./pages/ecommerce/shoppingCart.html" class="flex items-center">
                            <span class="mr-2 text-sm">•</span>
                            <span class="overflow-ellipsis">Shopping Cart</span>
                        </a>
                    </li>
                    <!-- end::Submenu link -->
                </ul>
                <!-- end::Submenu -->
            </div>
                    <!-- end::Menu link -->

                    <SingleSideLink  name="employee" title="employee" :class="{'bg-black bg-opacity-30':isActiveLink('employee')}">
                        <HomeIcon />
                    </SingleSideLink>

                    <SingleSideLink  name="product" title="product" :class="{'bg-black bg-opacity-30':isActiveLink('product')}">
                        <HomeIcon />
                    </SingleSideLink>
        
                    <!-- start::Menu link -->
            <!-- end::Menu link -->

            <SingleSideLink  name="profile" title="profile" :class="{'bg-black bg-opacity-30':isActiveLink('profile')}" :id=userId >
                <HomeIcon />
            </SingleSideLink>

            <!-- start::Menu link -->
            <a x-data="{ linkHover: false }" @mouseover="linkHover = true" @mouseleave="linkHover = false" href="#"
                @click="logout()"
                class="flex items-center text-gray-400 px-6 py-3 cursor-pointer hover:bg-black hover:bg-opacity-30 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition duration-200"
                    :class="linkHover ? 'text-gray-100' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                    </path>
                </svg>
                <span class="ml-3 transition duration-200" :class="linkHover ? 'text-gray-100' : ''">
                    logout
                </span>
            </a>
            <!-- end::Menu link -->

        </nav>
        <!-- end::Navigation -->
    </aside>
</template>


<script setup>
import {computed,defineEmits, onMounted,onUnmounted, ref} from "vue";
import { useRouter } from "vue-router";
import router from "../router";
import store from "../store";
import SingleSideLink from './Resusables/SingleSideLink.vue';
import HomeIcon from "./SvgsIcons/HomeIcon.vue";

const userId=sessionStorage.getItem('Auth')


const props = defineProps({
    menuOpen: {
    type: Boolean,
    default: true,
  }});
  const emit = defineEmits(['closeSideBar']);
function loggedUser() {
    store.dispatch("getLoggedUser").then((user) => {
        router.push({
            name: "profile",
            params:{id:userId}
        });
    });
}

function logout() {
    store.dispatch("logout").then(() => {
        router.push({
            name: "login",
        });
    });
}

function isActiveLink(linkName) {
   
      return useRouter().currentRoute.value.name=== linkName;
    }


    const handleClickOutside = (event) => {
      const sidebar = document.querySelector('.sidebar')
      if ( sidebar && !sidebar.contains(event.target) &&!sidebar.contains(event.target)) {

        emit('closeSideBar')
       
      }
    }

    onMounted(() => {
      document.addEventListener('click', handleClickOutside)
    })
    onUnmounted(() => {
      document.removeEventListener('click', handleClickOutside);
    });
   
</script>


<style scoped>

</style>