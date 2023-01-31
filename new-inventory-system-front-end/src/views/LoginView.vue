
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
import InputError from '../components/InputError.vue';
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
       errorMsg.value =response.data.errors;
    })
}

</script>