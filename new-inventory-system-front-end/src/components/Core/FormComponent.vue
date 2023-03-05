<template>
    <div class="h-full bg-gray-200 p-8">
      <div v-if="model.id" class="animate-fade-in-down">
        <FormCardLayout :title="title" v-slot="slotProps" >
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
           <!---->              
            <slot name="fields" :fields="fields" :model="model"></slot>
            </div>
  
            <footer class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
              <Button
                type="submit"
                :disabled="loading"
                :bgColor="buttonBgColor"
                :bgColorHoverClass="buttonBgColorHoverClass"
                :bgColorActiveClass="buttonBgColorActiveClass"
                class="mr-5"
                @click="redirectToRoute"
              >
              {{ submitLabel }}
              </Button>
  
              <RouterButton
                :to="{ name: `${props.redirectRoutName}` }"
                label="Cancel"
                ref="cancelButton"
              />
            </footer>
          </form>
        </FormCardLayout>
      </div>
  
      <div v-else class="animate-fade-in-down">
        <FormCardLayout :title="title" v-slot="slotProps">
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
              <slot name="fields" :fields="fields" :model="model"></slot>

            </div>
            <footer class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
              <Button
                type="submit"
                :disabled="loading"
                :bgColor="buttonBgColor"
                :bgColorHoverClass="buttonBgColorHoverClass"
                :bgColorActiveClass="buttonBgColorActiveClass"
                class="mr-5"
                @click="redirectToRoute"
              >
                Submit
              </Button>
  
              <RouterButton
                :to="{ name: `${props.redirectRoutName}` }"
                label="Cancel"></RouterButton>
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
  import Button from "./Button.vue";
  import RouterButton from "./RouteButton.vue";
  import CustomInput from "../CustomInput.vue";
  import FormCardLayout from "../Core/FormCardLayout.vue";
  
  const router = useRouter();
  const route = useRoute()
  
  const title = ref('');
  const model = ref(props.model);
  const loading = ref(false);

const props = defineProps({
    updateAction: {
    type: String,
  }, 

      fields: {
        type: Array,
        default: () => []
      },
      model: {
        type: Object,
        default: () => ({})
      },
      submitLabel: {
        type: String,
        default: 'Submit'
      },
  getAction: {
    type: String,
  },
  createAction: {
    type: String,
  },
  redirectRoutName: {
    type: String,
  },

});
let errorMsg = ref("");
  function onSubmit() {
    loading.value = true
    if (model.value.id) {
      store.dispatch(`${props.updateAction}`, model.value)
        .then(response => {
          loading.value = false;
          if (response.status === 200) {
            // TODO show notification
            store.dispatch(`${props.redirectRoutName}s`)
            router.push({name: `${props.redirectRoutName}`})
            store.commit('showToast', `model  has been Updated successfully`)
          }
        })
        .catch(err => {
          loading.value = false;
          errorMsg.value = err.response.data.errors;
        })
        
    } else {
      store.dispatch(`${props.createAction}`, model.value)
        .then(response => {
          loading.value = false;
          if (response.status === 201) {
            // TODO show notification
            store.dispatch(`${props.getAction}s`)
            router.push({name: `${props.redirectRoutName}`})
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
      store.dispatch(`${props.getAction}`, route.params.id)
        .then(({data}) => {
          title.value = `Update model: "${data.data.name} ${data.data.email}"`
          model.value = data.data
       
        })
    })
  }else{
    onMounted(()=>{
      title.value = `Create ${props.redirectRoutName}`
    })
  }
  
  </script>