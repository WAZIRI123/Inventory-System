
<template>
   <GuestLayout title="login">
                <form method="POST" @submit.prevent="login">
                <div class="mt-4">
                <!-- start::Default Input -->
               <CustomInput label="email" v-model="user.email" />
                <!-- end::Default Input -->
                </div>

                <div class="mt-4">
                <!-- start::Default Input -->
               <CustomInput label="password" v-model="user.password" />
                <!-- end::Default Input -->
                </div>
                <div class="mt-4" >
                <!-- start::Default Input -->
               <CustomInput type="checkbox" label="remember" v-model="user.remember"/>
                <!-- end::Default Input -->
                </div >

                <div class="mt-4">
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
let errorMsg = ref("");
const user ={
  email: '',
  password: '',
  remember: false
};

function login() {

  store.dispatch('login', user)

    .then(() => {
      router.push({name: 'dashboard'})
    })
    .catch(({response}) => {
      console.log(response)
    })
}

</script>