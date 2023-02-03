
<template>
   <GuestLayout title="login">
                <form method="POST" @submit.prevent="login">
                <div class="mt-4">
                <!-- start::Default Input -->
               <CustomInput label="email" v-model="user.email" />
                <!-- end::Default Input -->
     
                <InputError :messages="errorMsg.email?errorMsg.email[0]:errorMsg.email"/>
                </div>

                <div class="mt-4">
                <!-- start::Default Input -->
               <CustomInput label="password" v-model="user.password" />
                <!-- end::Default Input -->
                <InputError :messages="errorMsg.password?errorMsg.password[0]:errorMsg.password"/>
                </div>
                <div class="mt-4" >
                <!-- start::Default Input -->
               <CustomInput type="checkbox" label="remember" v-model="user.remember"/>
                <!-- end::Default Input -->
                <InputError/>
                </div >

                <div class="flex items-center justify-end mt-4">
                  <router-link to="/reset-link-view" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">Forgot your password?</router-link>

                 <CustomButton title="login" type="submit"/>
                </div>
            </form>
        </GuestLayout>

</template>

<script setup>
import CustomInput from '../components/CustomInput.vue';
import GuestLayout from '../components/GuestLayout.vue';

import CustomButton from '../components/CustomButton.vue';

import {ref} from 'vue'
import store from "../store";
import router from "../router";
import InputError from '../components/InputError.vue';
import { RouterLink } from 'vue-router';
let errorMsg = ref("");

const user ={
  email: '',
  password: '',
  remember: false
};

function login() {

  store.dispatch('login', user)

    .then((res) => {
      sessionStorage.setItem('Auth',res.user.id)
      router.push({name: 'dashboard'})
    })
    .catch(({response}) => {
      errorMsg.value=response.data.errors
    })
}

</script>