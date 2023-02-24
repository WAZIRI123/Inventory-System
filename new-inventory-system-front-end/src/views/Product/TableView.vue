<template>
    <TableComponent state="products"
     :headers="headers"
     getAction="getproduct"
     :createRoutName="createRoutName"
    >
    <slot name="table-body">waziri</slot>
    <template v-slot:table-body>
      <tr v-for="(item, index) in data.data" :key="item.id">
        <td :class="{'py-3 pl-2 bg-gray-400': isOdd(index), 'py-3 pl-2 bg-gray-200': !isOdd(index)}">{{ item.id }}</td>
        <td :class="{'py-3 pl-2 bg-gray-400': isOdd(index), 'py-3 pl-2 bg-gray-200': !isOdd(index)}">{{ item.name }}</td>
        <td :class="{'py-3 pl-2 bg-gray-400': isOdd(index), 'py-3 pl-2 bg-gray-200': !isOdd(index)}">{{ item.sale_price }}</td>
        <td :class="{'py-3 pl-2 bg-gray-400': isOdd(index), 'py-3 pl-2 bg-gray-200': !isOdd(index)}">{{ item.purchase_price }}</td>
        <td :class="{'py-3 pl-2 bg-gray-400': isOdd(index),'py-3 pl-2 bg-gray-200':!isOdd(index)}">
          <Menu as="div" class="relative inline-block text-left">
            <div>
              <MenuButton
                class="inline-flex items-center justify-center w-full justify-center rounded-full w-10 h-10 bg-black bg-opacity-0 text-sm font-medium text-white hover:bg-opacity-5 focus:bg-opacity-5 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
              >
              <DotsVerticalIcon
              :class="isOdd(index)?'h-5 w-5 text-white' :'h-5 w-5 text-indigo-500'"
              aria-hidden="true"/>
          </MenuButton>
        </div>
    
        <transition
          enter-active-class="transition duration-100 ease-out"
          enter-from-class="transform scale-95 opacity-0"
          enter-to-class="transform scale-100 opacity-100"
          leave-active-class="transition duration-75 ease-in"
          leave-from-class="transform scale-100 opacity-100"
          leave-to-class="transform scale-95 opacity-0"
        >
        <MenuItems
                class="absolute z-10 right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
              >
              <div class="px-1 py-1">
    
                <MenuItem v-slot="{ active }">
                  <router-link
                  :to="{name: 'products.view', params: {id: item.id}}"
                  :class="[
                    active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                    'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                  ]"
                >
                  <PencilIcon
                    :active="active"
                    class="mr-2 h-5 w-5 text-indigo-400"
                    aria-hidden="true"
                  />
                  Edit
                </router-link>
                </MenuItem>
                <MenuItem v-slot="{ active }">
                  <button
                    :class="[
                      active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                      'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                    ]"
                    @click="deleteitem(item)"
                  >
                    <TrashIcon
                      :active="active"
                      class="mr-2 h-5 w-5 text-indigo-400"
                      aria-hidden="true"
                    />
                    Delete
                  </button>
                </MenuItem>
              </div>
            </MenuItems>
          </transition>
        </Menu>
        </td>
      </tr>
    </template>
    </TableComponent>
      </template>
      
      <script setup>
    import {computed, onMounted, ref} from "vue";
    import store from "../../store";
    import {Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
        import {DotsVerticalIcon, PencilIcon, TrashIcon} from '@heroicons/vue/outline'
      
    import TableComponent from '../../components/Core/TableComponent.vue';
    
    const headers= ref(  [
          { field: 'id', label: 'Id' },
            { field: 'name', label: 'Name' },
            { field: 'sale_price', label: 'Sale Price' },
            { field: 'purchase_price', label: 'Purchase Price' },
            { field: 'action', label: 'Action' }
          ]);
          const createRoutName= ref('/products/create');
    
          const data = computed(() =>store.state.products) 
          function isOdd(index) {
          return index % 2 !== 0
        }
    
        function deleteitem(item) {
        if (!confirm(`Are you sure you want to delete the product?`)) {
          return
        }
        store.dispatch('deleteproduct', item)
          .then(res => {
            // TODO Show notification
            store.dispatch('getproducts')
            store.commit('showToast', `product  has been deleted successfully`)
          })
      }
      </script>
      
      <style scoped>
      
      </style>
      