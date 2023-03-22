<template>
  <FormComponent updateAction="updatesale" 
  :fields="fields"
  submitLabel="Submit"
  redirectRoutName="sale" getAction="getsale" createAction="createsale">
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
                    :selectOptions="products"
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

const fields = ref([
{ name: 'quantity', label: 'Quantity', type: 'text', required: true },
{ name: 'product_id', label: 'Product', type: 'select', required: true },


    ])    
  const products = ref([])

      onMounted(()=>
      store.dispatch('getproductsForSale')
          .then(res => {
            products.value=res.data.data

          }))
      
</script>