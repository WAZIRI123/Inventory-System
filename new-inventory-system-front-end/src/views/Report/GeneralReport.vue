<template>
    <GeneralTableComponent state="sales"
     :headers="headers"
     getAction="getReport"
     :createRoutName="createRoutName"
    >
  
    <template v-slot:table-body>
      <tr v-for="(item, index) in data.data" :key="item.id">
        <td :class="{'py-3 pl-2 bg-gray-400': isOdd(index), 'py-3 pl-2 bg-gray-200': !isOdd(index)}">{{ item.id }}</td>
        <td :class="{'py-3 pl-2 bg-gray-400': isOdd(index), 'py-3 pl-2 bg-gray-200': !isOdd(index)}">{{ item.product_name }}</td>
        <td :class="{'py-3 pl-2 bg-gray-400': isOdd(index), 'py-3 pl-2 bg-gray-200': !isOdd(index)}">{{ item.quantity }}</td>
        <td :class="{'py-3 pl-2 bg-gray-400': isOdd(index), 'py-3 pl-2 bg-gray-200': !isOdd(index)}">{{ item.employee_name }}</td>
  
      </tr>
    </template>
    </GeneralTableComponent>
      </template>
      
      <script setup>
    import {computed, onMounted, ref} from "vue";
    import store from "../../store";
    import {Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
        import {DotsVerticalIcon, PencilIcon, TrashIcon} from '@heroicons/vue/outline'
      
import GeneralTableComponent from "../../components/Core/GeneralTableComponent.vue";
    
    const headers= ref(  [
          { field: 'id', label: 'Id' },
            { field: 'product_name', label: 'product' },
            { field: 'quantity', label: 'Quantity' },
            { field: 'employee_name', label: 'employee' },
        
          ]);
          const createRoutName= ref('/sales/create');
    
          const data = computed(() =>store.state.sales) 
      
          function isOdd(index) {
          return index % 2 !== 0
        }
   
        function deleteitem(item) {
        if (!confirm(`Are you sure you want to delete the sale?`)) {
          return
        }
    store.dispatch('deletesale', item)
   .then(res => {
 if (res.status === 200) { // check if deletion is successful
    // show success message to user
    store.dispatch('getsales')
    store.commit('showToast', {message:'sale has been deleted successfully.'})
  }
}).catch(error => {
  if (error.response.status === 403) { // check if user is unauthorized
    // show error message to user
    store.commit('showToast', {message:'You are not authorized to perform this action.',type:'danger'})
  } 

  else{

    store.commit('showToast', {message:'An error occurred while deleting the sale.',type:'danger'})
  }
  // show error message to user
})
      }
      onMounted(()=>{
        store.state.sales={
        loading: false,
        data: [],
        links: [],
        from: null,
        to: null,
        page: 1,
        limit: null,
        total: null
    }
      })
      </script>
      
      <style scoped>
      
      </style>
      