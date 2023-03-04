<template>
    <div class="form-container">
      <form @submit.prevent="onSubmit">
        <slot name="fields" :fields="fields" :model="model"></slot>
        <div class="form-actions">
          <button type="submit" :disabled="loading">{{ submitLabel }}</button>
          <router-link v-if="cancelRoute" :to="cancelRoute">{{ cancelLabel }}</router-link>
        </div>
      </form>
    </div>
  </template>
  
  <script>
  import { ref, watch } from 'vue'
  
  export default {
    props: {
      fields: {
        type: Array,
        default: () => []
      },
      model: {
        type: Object,
        default: () => ({})
      },
      submitAction: {
        type: String,
        required: true
      },
      submitLabel: {
        type: String,
        default: 'Submit'
      },
      cancelLabel: {
        type: String,
        default: 'Cancel'
      },
      cancelRoute: {
        type: [String, Object],
        default: null
      }
    },
    emits: ['submit'],
    setup(props, { emit }) {
      const loading = ref(false)
      const errors = ref({})
      const model = ref(props.model)
  
      const onSubmit = async () => {
        loading.value = true
        try {
          await store.dispatch(props.submitAction, model.value)
          emit('submit')
        } catch (error) {
          errors.value = error.response.data.errors
        }
        loading.value = false
      }
  
      watch(model, () => {
        errors.value = {}
      }, { deep: true })
  
      return {
        loading,
        errors,
        model,
        onSubmit
      }
    }
  }
  </script>
  