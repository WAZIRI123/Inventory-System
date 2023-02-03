
<template>
    <GuestLayout title="Reset Link">
                 <form method="POST" @submit.prevent="sendPasswordResetLink">
                  <InputError :messages="throttledMsg?throttledMsg:throttledMsg"/>
                 <div class="mt-4">
                 <!-- start::Default Input throttledMsg-->
                <CustomInput label="email" v-model="user.email" />
                 <!-- end::Default Input -->
      
                 <InputError :messages="errorMsg?errorMsg.email[0]:errorMsg"/>
                 </div>
 
                 <div class="flex items-center justify-end mt-4">
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
 let throttledMsg = ref("");
 const user ={ 
    email:'',
 };
 
 function sendPasswordResetLink() {
 
   store.dispatch('sendResetPasswordLinkAction', user)
 
     .then((res) => {
      if (!res.throttled) 
      {
         sessionStorage.setItem('token',res.token)
         sessionStorage.setItem('email',user.email)
         router.push({name: 'NewPassword'})

      }
      else{
         
         throttledMsg.value = res.throttled;
      }
     })
     .catch(({response}) => {

      errorMsg.value =response.data.errors;

     })
 }
 
 </script>