<template>
    <GuestLayout title="">
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Reset Password <Toast/>
            </h2>
            
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update your account's profile information and email address.
            </p>
        </header>
    
        <form method="post"  class="mt-6 space-y-6" @submit.prevent="passwordReset">
            <InputError :messages="errorToken?errorToken:errorToken"/>
                <div class="mt-4">
                <!-- start::Default Input -->
               <CustomInput label="password" v-model="user.password" type="password" />
                <!-- end::Default Input -->
                <InputError :messages="errorMsg.password?errorMsg.password[0]:errorMsg.password"/>
                </div>
        
                <div class="mt-4">
                <!-- start::Default Input -->
               <CustomInput label="password_confirmation" v-model="user.password_confirmation" type="password" />
                <!-- end::Default Input -->
                <InputError :messages="errorMsg.password_confirmation?errorMsg.password_confirmation[0]:errorMsg.password_confirmation"/>
                </div>
                <div class="flex items-center justify-end mt-4">
                  <router-link to="/login" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 
                  mr-3 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">login</router-link>

                 <CustomButton title="save" type="submit"/>
                </div>
        </form>
    </section>
</GuestLayout>
</template>
<script setup>
import { ref,watch} from 'vue';
import store from "../store";
import { useRoute, useRouter } from "vue-router";
import CustomButton from '../components/CustomButton.vue';
import CustomInput from '../components/CustomInput.vue';
import InputError from '../components/InputError.vue';
import Toast from '../components/Toast.vue';
import GuestLayout from '../components/GuestLayout.vue';
import axiosClient from '../axios';


let errorMsg = ref("");

let errorToken = ref("");
const router = useRouter();

const route = useRoute();


let user =ref({
  token:sessionStorage.getItem('token'),
  email:sessionStorage.getItem('email'),
  password: '',
  password_confirmation: ''
});

const emit = defineEmits(['user:updated']);

function passwordReset() {
  return axiosClient.patch('/password-reset', { ...user.value })
  .then(() => {
  
    store.commit('showToast', `Password has been Reseted successfully`)

  }).catch(({response}) => {
    if (response.data.errors) {
        
        errorMsg.value =response.data.errors;
    } else {

        errorToken.value=response.data.message
    }
    });

}


</script>