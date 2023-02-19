<template>
  <div class="h-full bg-gray-200 p-8">
  <div v-if="employee.id" class="animate-fade-in-down">
    <FormCardLayout :title=title>
      <form @submit.prevent="onSubmit" class="mt-8">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
          <CustomInput class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full rounded-md" v-model="employee.name" label="Last Name"/>
          <CustomInput class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full rounded-md" v-model="employee.email" label="Email"/>
          </div>
  
        <footer class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button type="submit"
                  class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm
                            text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500">
            Submit
          </button>
          <router-link :to="{name: 'employee'}" type="button"
                       class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                       ref="cancelButtonRef">
            Cancel
          </router-link>
        </footer>
      </form>
    </FormCardLayout>
    </div>

    <div v-else class="animate-fade-in-down">
      <FormCardLayout :title=title>
      <form @submit.prevent="onSubmit" class="mt-8">
        <Alert v-if="errorMsg">
          <li v-for="(error, index) in  errorMsg" :key="index">
        {{ errorMsg[index][0]}} 
      </li>
 
      <span
        @click="errorMsg = ''"
        class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-6 w-6"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12"
          />
        </svg>
      </span>
    </Alert>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
          <CustomInput class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full rounded-md" v-model="employee.name" label="Last Name"/>
          <CustomInput class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full rounded-md" v-model="employee.email" label="Email"/>
          </div>
          <footer class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button type="submit"
                  class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm
                            text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500">
            Submit
          </button>
          <router-link :to="{name: 'employee'}" type="button"
                       class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                       ref="cancelButtonRef">
            Cancel
          </router-link>
        </footer>
      </form>
      </FormCardLayout>
    </div>
  </div>
  </template>
  
  <script setup>
  import {computed, onMounted, ref} from "vue";
  import store from "../../store";
  import {useRoute, useRouter} from "vue-router";
  import CustomInput from "../../components/CustomInput.vue";
import FormCardLayout from "../../components/Core/FormCardLayout.vue";
  
  const router = useRouter();
  const route = useRoute()
  
  const title = ref('');

  const loading = ref(false);
  const employee = ref({
id:'',
name:'',
email:''
});
let errorMsg = ref("");
  function onSubmit() {
    loading.value = true
    if (employee.value.id) {
      store.dispatch('updateemployee', employee.value)
        .then(response => {
          loading.value = false;
          if (response.status === 200) {
            // TODO show notification
            store.dispatch('getemployees')
            router.push({name: 'employee'})
            store.commit('showToast', `Employee  has been Updated successfully`)
          }
        })
        .catch(err => {
          loading.value = false;
          errorMsg.value = err.response.data.errors;
        })
        
    } else {
      store.dispatch('createemployee', employee.value)
        .then(response => {
          loading.value = false;
          if (response.status === 201) {
            // TODO show notification
            store.dispatch('getemployees')
            router.push({name: 'employee'})
          }
        })
        .catch(err => {
          loading.value = false;
          errorMsg.value = err.response.data.errors;
        })
    }
  }
  if (route.params.id) {
   
    onMounted(() => {
      store.dispatch('getemployee', route.params.id)
        .then(({data}) => {
          title.value = `Update employee: "${data.data.name} ${data.data.email}"`
          employee.value = data.data
       
        })
    })
  }else{
    onMounted(()=>{
      title.value = `Create Employee`
    })
  }
  
  </script>
  
  <style scoped>
  
  </style>
  