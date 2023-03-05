<template>
  <FormComponent updateAction="updateemployee" 
  :fields="fields"
  :model="model"
  submitLabel="Submit"
  redirectRoutName="employee" getAction="getemployee" createAction="createemployee">
  <template #fields="{ fields, model }">
    <div v-for="(field, index) in fields" :key="index">
      <CustomInput
      v-model="model[field.name]"
      :label="field.label"
      :type="field.type"
      :class="customInputClass"
    />
      <p v-if="errors[field.name]" class="error">{{ errors[field.name][0] }}</p>
    </div>
  </template>
</FormComponent>
</template>
<script setup>
  import { ref} from "vue";
import FormComponent from '../../components/Core/FormComponent.vue';
import CustomInput from "../../components/CustomInput.vue";

const fields = [
        { name: 'name', label: 'Name', type: 'text', required: true },
        { name: 'email', label: 'Email', type: 'text', required: true },
      ]
      const model = ref({ name: '' })
      const errors = ref({})

</script>