<template>
  <div class="h-full bg-gray-200 p-8">
 

      <h4 class="text-xl font-semibold">Advance Table</h4>
      <table class="w-full my-8 whitespace-nowrap">
        <thead class="bg-secondary text-gray-100 font-bold">
          <tr>
            <td></td>
            <td class="py-2 pl-2">ID</td>
            <td class="py-2 pl-2">Name</td>
            <td class="py-2 pl-2">Email</td>
          </tr>
        </thead>
        <tbody class="text-sm">
          <tr
            class="bg-gray-100 hover:bg-primary hover:bg-opacity-20 transition duration-200"
            v-for="(employee, index) in employees"
            :key="index"
          >
            <td class="py-3 pl-2">
              <input type="checkbox" class="rounded focus:ring-0 checked:bg-red-500 ml-2" />
            </td>
            <td class="py-3 pl-2">{{ employee.id }}</td>
            <td class="py-3 pl-2">{{ employee.name }}</td>
            <td class="py-3 pl-2">{{ employee.email }}</td>
          </tr>
        </tbody>
        <div class="flex justify-end">
          <button
            class="btn btn-primary mr-2"
            :disabled="meta.current_page === 1"
            v-if="meta.last_page > 1"
            @click="paginate(meta.current_page - 1)"
          >
            Prev
          </button>
          <button
            class="btn btn-primary mr-2"
            :disabled="meta.current_page === meta.last_page"
            v-if="meta.last_page > 1"
            @click="paginate(meta.current_page + 1)"
          >
            Next
          </button>
        </div>
      </table>
    </div>
 

  </template>
  
  <script setup>
import { ref, onMounted } from 'vue';

import store from '../store';
    const employees = ref([]);
    const meta= ref({
      
    });

onMounted(()=>{
   store.dispatch('fetchEmployees')
 .then(()=>{
  employees.value=store.state.employees.data;

  meta.value=store.state.employees.meta;

 });

});

function paginate(page) {
  store.dispatch('fetchEmployees',  page )
  .then(()=>{
  employees.value=store.state.employees.data;

  meta.value=store.state.employees.meta;

 });
}

  </script>
  