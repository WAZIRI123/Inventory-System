<template>
  <FormComponent updateAction="updateproduct" 
  :fields="fields"
  submitLabel="Submit"
  redirectRoutName="product" getAction="getproduct" createAction="createproduct">
  <template #fields="{ fields, model,errorMsg }">
    <div v-for="(field, index) in fields" :key="index">

      <div class="mt-4">
        <CustomInput v-if="field.type==='text'"
        v-model="model[field.name]"
        :label="field.label"
        :type="field.type"
        :class="customInputClass"
            />
            
          </div>
          <div class="mt-4">
            <CustomInput v-if="field.type==='select'"
            v-model="model[field.name]"
            :label="field.label"
            :type="field.type"
            :selectOptions="vendors"
            :class="customInputClass"
            />
            <InputError v-if="errorMsg[field.name] " :messages="errorMsg[field.name][0]?errorMsg[field.name][0]:errorMsg[field.name][0]"/>
          </div>
          
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
        { name: 'vendor_id', label: 'Vendor', type: 'select', required: true },
        { name: 'description', label: 'Description', type: 'text', required: true },
        { name: 'purchase_price', label: 'Purchase_price', type: 'text', required: true },
               { name: 'sale_price', label: 'Sale_price', type: 'text', required: true },

               { name: 'quantity', label: 'Quantity', type: 'text', required: true },
      ]
      const vendors = ref([])

      onMounted(()=>store.dispatch('getvendors')
          .then(res => {
         vendors.value=res.data.data
          }))
      
</script>