<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Create Password Reset Token <Toast/>
            </h2>
            
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                To Reset Your Password You Required to Create Password Reset Token First.
            </p>
        </header>
    
        <form method="post"  class="mt-6 space-y-6" @submit.prevent="createToken">
          <InputError :messages="throttledMsg?throttledMsg.value:'waz'"/>
            <div class="mt-4">
                <!-- start::Default Input -->
               <CustomInput label="email" v-model="user.email" />
                <!-- end::Default Input -->
        
                <InputError :messages="errorMsg.email?errorMsg.email[0]:errorMsg.email"/>
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
let throttledMsg = ref("");
const router = useRouter();

const route = useRoute();


let user =ref({
  email: '',
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
  
    store.commit('showToast', `Profile has been updated successfully`)

  }).catch(({response}) => {
    if (response.data.errors) {
      errorMsg.value =response.data.errors;
    }
    else{

      throttledMsg.value=response.data.throttled
    }
       
    });

}


</script>