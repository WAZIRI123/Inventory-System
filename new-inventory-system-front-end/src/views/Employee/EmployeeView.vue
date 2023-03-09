<template>
  <FormComponent updateAction="updateemployee" 
  :fields="fields"
  :model="model"
  submitLabel="Submit"
  redirectRoutName="employee" getAction="getemployee" createAction="createemployee">
  <template #fields="{ fields, model,errorMsg }">
    <div v-for="(field, index) in fields" :key="index">
      
      <div class="mt-4">
        <CustomInput
        v-model="model[field.name]"
        :label="field.label"
        :type="field.type"
        :class="customInputClass"
            />
            <InputError v-if="errorMsg[field.name] " :messages="errorMsg[field.name][0]?errorMsg[field.name][0]:errorMsg[field.name][0]"/>
      </div>
    </div>
  </template>
</FormComponent>
</template>
<script setup>
  import { ref} from "vue";
import FormComponent from '../../components/Core/FormComponent.vue';
import CustomInput from "../../components/CustomInput.vue";
import InputError from "../../components/InputError.vue";

const fields = [
        { name: 'name', label: 'Name', type: 'text', required: true },
        { name: 'email', label: 'Email', type: 'text', required: true },
      ]
      
      const errors = ref({})

</script>