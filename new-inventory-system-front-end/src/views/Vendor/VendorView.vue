<template>
    <FormComponent updateAction="updatevendor" 
    :fields="fields"
    submitLabel="Submit"
    redirectRoutName="vendor" getAction="getvendor" createAction="createvendor">
    <template #fields="{ fields, model,errorMsg }">
      <div v-for="(field, index) in fields" :key="index">
  
          <CustomInput v-if="field.type==='text'"
          v-model="model[field.name]"
          :label="field.label"
          :type="field.type"
          :class="customInputClass"
              />
              <CustomInput v-if="field.type==='select'"
              v-model="model[field.name]"
              :label="field.label"
              :type="field.type"
              :selectOptions="vendors"
              :class="customInputClass"
              />
              <InputError v-if="errorMsg[field.name] " :messages="errorMsg[field.name][0]?errorMsg[field.name][0]:errorMsg[field.name][0]"/>
      
            
          </div>
    </template>
  </FormComponent>
  </template>
  <script setup>
    import {computed, onMounted, ref} from "vue";
  import FormComponent from '../../components/Core/FormComponent.vue';
  import CustomInput from "../../components/CustomInput.vue";
  import InputError from "../../components/InputError.vue";
  import store from "../../store";
  
  const fields = [
          { name: 'name', label: 'Name', type: 'text', required: true },

          { name: 'contact_email', label: 'contact email', type: 'text', required: true },
          { name: 'contact_phone', label: 'contact_phone', type: 'text', required: true },
                 { name: 'payment_terms', label: 'payment_terms', type: 'text', required: true },
                 { name: 'quantity', label: 'Quantity', type: 'text', required: true },
        ]
     
  
  </script>