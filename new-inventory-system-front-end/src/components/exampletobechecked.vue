<template>
    <div>
      <h1>Contact Us</h1>
      <Form
        :fields="fields"
        :model="model"
        submitAction="submitContactForm"
        @submit="onSubmit"
        submitLabel="Submit"
        cancelLabel="Cancel"
        cancelRoute="/"
      >
        <template #fields="{ fields, model }">
          <div v-for="(field, index) in fields" :key="index">
            <label :for="field.name">{{ field.label }}</label>
            <input :id="field.name" v-model="model[field.name]" :type="field.type" />
            <p v-if="errors[field.name]" class="error">{{ errors[field.name][0] }}</p>
          </div>
        </template>
      </Form>
    </div>
  </template>
  
  <script>
  import Form from '@/components/Form.vue'
  import { ref } from 'vue'
  
  export default {
    components: { Form },
    setup() {
      const fields = [
        { name: 'name', label: 'Name', type: 'text', required: true },
        { name: 'email', label: 'Email', type: 'email', required: true },
        { name: 'message', label: 'Message', type: 'textarea', required: true }
      ]
      const model = ref({ name: '', email: '', message: '' })
      const errors = ref({})
  
      const onSubmit = () => {
        console.log('Form submitted')
      }
  
      return {
        fields,
        model,
        errors,
        onSubmit
      }
    }
  }
  </script>
  