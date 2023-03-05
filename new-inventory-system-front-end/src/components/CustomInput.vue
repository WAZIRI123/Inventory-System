<template>
      <label class="sr-only" :for="label">{{ label }}</label>
        <span v-if="prepend"
              class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
          {{ prepend }}
        </span>
        <template v-if="type === 'select'">
          <select :name="name"
                  :required="required"
                  :value="props.modelValue"
                  :class="inputClasses"
                  @change="onChange($event.target.value)">
            <option v-for="option of selectOptions" :value="option.key">{{ option.text }}</option>
            
          </select>
        </template>
        <template v-else-if="type === 'textarea'">
        <textarea :name="name"
                  :required="required"
                  :value="props.modelValue"
                  @input="emit('update:modelValue', $event.target.value)"
                  :class="inputClasses"
                  :placeholder="label"></textarea>
        </template>
        <template v-else-if="type === 'file'">
          <input :type="type"
                 :name="name"
                 :required="required"
                 :value="props.modelValue"
                 @input="emit('change', $event.target.files[0])"
                 :class="inputClasses"
                 :placeholder="label"/>
        </template>
        <template v-else-if="type === 'checkbox'">
          <input :id="id"
                 :name="name"
                 :type="type"
                 :checked="props.modelValue"
                 :required="required"
                 @change="emit('update:modelValue', $event.target.checked)"
                 class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"/>
                 <label :for="id" class="ml-2  text-sm text-gray-900"> {{ label }} </label>
        </template>
        <template v-else>
          <input :type="type"
                 :name="name"
                 :required="required"
                 :value="props.modelValue"
                 @input="emit('update:modelValue', $event.target.value)"
                 :class="inputClasses"
                 :placeholder="label"
                 step="0.01"/>
        </template>
        <span v-if="append"
              class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
          {{ append }}
        </span>
  </template>
  
  <script setup>
  
  import {computed, ref} from "vue";
  
  const props = defineProps({
    modelValue: [String, Number, File,Boolean],
    label: String,
    type: {
      type: String,
      default: 'text'
    },
    name: String,
    required: Boolean,
    prepend: {
      type: String,
      default: ''
    },
    append: {
      type: String,
      default: ''
    },
    selectOptions: Array
  })
  
  const id = computed(() => {
    if (props.id) return props.id;
  
    return `id-${Math.floor(1000000 + Math.random() * 1000000)}`;
  })
  const inputClasses = computed(() => {
    const cls = [
      `border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full`,
    ];
  
    if (props.append && !props.prepend) {
      cls.push(`rounded-l-md`)
    } else if (props.prepend && !props.append) {
      cls.push(`rounded-r-md`)
    } else if (!props.prepend && !props.append) {
      cls.push('rounded-md')
    }
    return cls.join(' ')
  })
  const emit = defineEmits(['update:modelValue', 'change'])
  
  function onChange(value) {
    emit('update:modelValue', value)
    emit('change', value)
  }
  
  </script>
  
  <style scoped>
  
  </style>