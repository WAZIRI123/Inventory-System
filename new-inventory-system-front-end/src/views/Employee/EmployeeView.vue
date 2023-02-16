<template>
    <div v-if="employee.id" class="animate-fade-in-down">
      <FormCardLayout :title=title>
      <form @submit.prevent="onSubmit">
        <div class="bg-white px-4 pt-5 pb-4">
          <div class="grid grid-cols-2 gap-8">
          <CustomInput class="mb-2" v-model="employee.name" label="Last Name"/>
          <CustomInput class="mb-2" v-model="employee.email" label="Email"/>
          </div>
  
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
      <form @submit.prevent="onSubmit">
        <div class="bg-white px-4 pt-5 pb-4">
          <div class="grid grid-cols-2 gap-8">
          <CustomInput class="mb-2" v-model="employee.name" label="Last Name"/>
          <CustomInput class="mb-2" v-model="employee.email" label="Email"/>
          </div>
  
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
          debugger;
        })
    }
  }
  
  onMounted(() => {
    store.dispatch('getemployee', route.params.id)
      .then(({data}) => {
        title.value = `Update employee: "${data.data.name} ${data.data.email}"`
        employee.value = data.data
     
      })
  })
  
  </script>
  
  <style scoped>
  
  </style>
  