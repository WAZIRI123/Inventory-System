<template>
  <FormComponent updateAction="updateproduct" 
  :fields="fields"
  :model="model"
  submitLabel="Submit"
  redirectRoutName="product" getAction="getproduct" createAction="createproduct">
  <template #fields="{ fields, model }">
    <div v-for="(field, index) in fields" :key="index">

      <CustomInput v-if="field.type==='text'"
      v-model="model[field.name]"
      :label="field.label"
      :type="field.type"
      :class="customInputClass"
    />

    <CustomInput v-if="field.type==='select'"
      v-model="model[field.vendor_id]"
      :label="field.label"
      :type="field.type"
      :selectOptions="vendors"
      :class="customInputClass"
    />
      <p v-if="errors[field.vendor_id]" class="error">{{ errors[field.vendor_id][0] }}</p>
    </div>
  </template>
</FormComponent>
</template>
<script setup>
  import {computed, onMounted, ref} from "vue";
import FormComponent from '../../components/Core/FormComponent.vue';
import CustomInput from "../../components/CustomInput.vue";
import store from "../../store";

const fields = [
        { name: 'name', label: 'Name', type: 'text', required: true },
        { name: 'vendor_id', label: 'Vendor', type: 'select', required: true },
      ]
      const model = ref({ name: '' ,vendor_id:''})
      const errors = ref({})
      const vendors = ref([])

      onMounted(()=>store.dispatch('getvendors')
          .then(res => {
         vendors.value=res.data.data
          }))
      
</script>