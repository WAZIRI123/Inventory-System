<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Profile Information
            </h2>
    
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update your account's profile information and email address.
            </p>
        </header>
    
        <form method="post"  class="mt-6 space-y-6" @submit.prevent="saveUser">

            <div class="mt-4">
                <!-- start::Default Input -->
               <CustomInput label="email" v-model="user.email" />
                <!-- end::Default Input -->
        
                <InputError :messages="errorMsg.email?errorMsg.email[0]:errorMsg.email"/>
                </div>
        
                <div class="mt-4">
                <!-- start::Default Input -->
               <CustomInput label="name" v-model="user.name" />
                <!-- end::Default Input -->
                <InputError :messages="errorMsg.name?errorMsg.name[0]:errorMsg.name"/>
                </div>
                <div class="mt-4" >
                <!-- start::Default Input -->
               <CustomInput type="checkbox" label="remember" v-model="user.remember"/>
                <!-- end::Default Input -->
                <InputError/>
                </div >
        
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

let errorMsg = ref("");
const router = useRouter();

const route = useRoute();


let user =ref({
  email: '',
  password: '',
  remember: false
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
  
  store.dispatch("saveUser", { ...user.value }).then(({ data }) => {
  
    emit('user:updated', 'User has been updated successfully')

  });

}


</script>