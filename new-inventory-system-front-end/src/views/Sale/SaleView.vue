<template>
  <FormComponent updateAction="updatesale" 
  :fields="fields"
  submitLabel="Submit"
  @add-form="addForm()"

  @remove-form="removeForm()"
  redirectRoutName="sale" getAction="getsale" createAction="createsale">
  <template #fields="{ fields, model,errorMsg }">
   
      <div v-for="(field, index) in fields" :key="index">
        
            <div class="mb-6">
              <CustomInput v-if="field.type==='text'"
              v-model="model[field.name]"
              :label="field.label"
              :type="field.type"
              :class="customInputClass"
                  />
                  <div v-if="field.type==='select'">
                    <CustomInput
                    v-model="model[field.product_id]"
                    :label="field.label"
                    :type="field.type"
                    :selectOptions="products"
                    :class="customInputClass"
                    />
                    <InputError v-if="errorMsg[field.name] " :messages="errorMsg[field.name][0]?errorMsg[field.name][0]:errorMsg[field.name][0]"/>
                  </div>
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

  { name: 'product_id', label: 'Product', type: 'select', required: true },
  { name: 'quantity', label: 'Quantity', type: 'text', required: true },

      ]
      const products = ref([])

      let  itemCount = ref(2)

 

    function addForm(){
   alert('waziri')
    }

    function removeForm(){
      if (fields.length>2) {
        
        fields.splice(
     -1,2)
      }else{
        alert('you can not remove all fields')
      }
    }


    const incrementItemCount = () => {

        itemCount.value++
      
    }

      onMounted(()=>
      store.dispatch('getproducts')
          .then(res => {
            products.value=res.data.data

          }))
      
</script>