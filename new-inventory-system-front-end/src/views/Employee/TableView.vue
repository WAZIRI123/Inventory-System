<template>
<TableComponent state="employees"
 :headers="headers"

></TableComponent>
  </template>
  
  <script setup>
import {computed, onMounted, ref} from "vue";
import TableComponent from '../../components/Core/TableComponent.vue';

const headers= ref(  [
      { field: 'id', label: 'Id' },
        { field: 'name', label: 'Name' },
        { field: 'email', label: 'Email' },
        { field: 'action', label: 'Action' }
      ]);

      
  </script>
  
  <style scoped>
  
  </style>
  