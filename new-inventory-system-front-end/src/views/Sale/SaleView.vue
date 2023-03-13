<template>
  <FormComponent updateAction="updatesale" 
  :fields="fields"
  submitLabel="Submit"
  redirectRoutName="sale" getAction="getsale" createAction="createsale">
  <template #fields="{ fields, model,errorMsg }">
   
      <div v-for="(field, index) in fields" :key="index">
        <div v-for="i in itemCount" :key="i">
          <CustomInput v-if="field.type==='text'"
          v-model="model[field.name]"
          :label="field.label"
          :type="field.type"
          :class="customInputClass"
              />
              <div v-if="field.type==='select'">
                <CustomInput
                v-model="model[field.name]"
                :label="field.label"
                :type="field.type"
                :selectOptions="vendors"
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

  { name: 'vendor_id', label: 'Vendor', type: 'select', required: true },
  { name: 'quantity', label: 'Quantitys', type: 'text', required: true },

      ]
      const vendors = ref([])

      let  itemCount = ref(2)

    const decrementItemCount = () => {
      if (itemCount.value > 1) {
        itemCount.value--
      }
    }

    const incrementItemCount = () => {

        itemCount.value++
      
    }

      onMounted(()=>store.dispatch('getvendors')
          .then(res => {
         vendors.value=res.data.data
          }))
      
</script>