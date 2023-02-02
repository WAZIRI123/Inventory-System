<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Update Password <Toast/>
            </h2>
            
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update your account's password
            </p>
        </header>
    
        <form method="post"  class="mt-6 space-y-6" @submit.prevent="saveUser">

            <div class="mt-4">
                <!-- start::Default Input -->
               <CustomInput label="current_password" v-model="user.current_password" type="password" />
                <!-- end::Default Input -->
        
                <InputError :messages="errorMsg.current_password?errorMsg.current_password[0]:errorMsg.current_password"/>
                </div>
        
                <div class="mt-4">
                <!-- start::Default Input -->
               <CustomInput label="password" v-model="user.password" type="password"/>
                <!-- end::Default Input -->
                <InputError :messages="errorMsg.password?errorMsg.password[0]:errorMsg.password" />
                </div>

                <div class="mt-4">
                <!-- start::Default Input -->
               <CustomInput label="password_confirmation" v-model="user.password_confirmation" type="password"/>
                <!-- end::Default Input -->
                <InputError :messages="errorMsg.password_confirmation?errorMsg.password_confirmation[0]:errorMsg.password_confirmation"/>
                </div>
                <div class="mt-4">
                 <CustomButton title="Save" type="submit"/>
                </div>
        </form>
    </section>
    
</template>
<script setup>
import { ref,watch} from 'vue';
import store from "../../store";
import { useRoute, useRouter } from "vue-router";
import CustomButton from '../CustomButton.vue';
import CustomInput from '../CustomInput.vue';
import InputError from '../InputError.vue';
import Toast from '../Toast.vue';

let errorMsg = ref("");
const router = useRouter();

const route = useRoute();


let user =ref({
  current_password: '',
  password: '',
  password_confirmation: ''
});

if (route.params.id) {
store.dispatch("getUser", route.params.id);

}
watch(
  () => store.state.user.data,
  (newVal, oldVal) => {
    
    user.value = {
      ...JSON.parse(JSON.stringify(newVal)),
    };
  }
);
const emit = defineEmits(['user:updated']);

function saveUser() {
  
  store.dispatch("updatePassword", { ...user.value }).then(({ data }) => {
  
    store.commit('showToast', `Password  has been updated successfully`)

  }).catch(({response}) => {
       errorMsg.value =response.data.errors;
    });

}


</script>