<template>
  <div class="bg-white rounded-lg px-8 py-0 overflow-x-scroll custom-scrollbar">
    <h4 class="text-xl font-semibold">{{ title }}</h4>

    <div class="flex justify-between  pb-3">
      <div class="flex items-center">
        <span class="whitespace-nowrap mr-3">{{ perPageLabel }}</span>

        <select @change="getitems(null)" v-model="perPage"
                class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
          <option v-for="option in perPageOptions" :key="option.value" :value="option.value">
            {{ option.label }}
          </option>
        </select>
        <span class="ml-3">Found {{data.total}} employees</span>
      </div>

      <Button :disabled="data.loading" class="mr-5" @click="createNew">{{ createNewLabel }}</Button>

      <div>
        <input v-model="search" @change="getitems(null)"
               class="appearance-none relative block w-48 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
               placeholder="Search...">
      </div>
    </div>

    <table class="w-full my-0 whitespace-nowrap">
      <thead class="bg-secondary text-gray-100 font-bold">
        <Toast/>
        <tr>
          <TableHeaderCell v-for="header in props.headers" :key="header.field"
                           :field="header.field" :sort-field="sortField" :sort-direction="sortDirection"
                           @click="sortItems(header.field)">
            {{ header.label }}
          </TableHeaderCell>
        </tr>
      </thead>

      <tbody class="text-sm" v-if="data.loading || !data.data.length">
        <tr class="bg-gray-100 hover:bg-primary hover:bg-opacity-20 transition duration-200">
          <td :colspan="headers.length" class="py-8 text-center text-gray-700">
            <Spinner v-if="data.loading"/>
            <p v-else>{{ noResultsLabel }}</p>
          </td>
        </tr>
      </tbody>

      <tbody v-else>
        <tr v-for="(item, index) in data.data" :key="item.id">
          <td :class="{'py-3 pl-2 bg-gray-400': isOdd(index), 'py-3 pl-2 bg-gray-200': !isOdd(index)}">{{ item.id }}</td>
          <td :class="{'py-3 pl-2 bg-gray-400': isOdd(index), 'py-3 pl-2 bg-gray-200': !isOdd(index)}">{{ item.name }}</td>
          <td :class="{'py-3 pl-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis bg-gray-400': isOdd(index), 'py-3 pl-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis bg-gray-200': !isOdd(index)}">{{ item.email }}</td>
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
                    :to="{name: 'employees.view', params: {id: item.id}}"
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
      </tbody>
    </table>
    <div v-if="!data.loading" class="sm:flex justify-center sm:justify-between items-center mt-5 text-center">
      <div v-if="data.data.length" class="mb-3">
        Showing from {{ data.from }} to {{ data.to }}
      </div>

      <nav
      v-if="data.total > data.limit"
      class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
      aria-label="Pagination"
    >
    <a
    v-for="(link, i) of data.links"
    :key="i"
    :disabled="!link.url"
    href="#"
    @click="getForPage($event, link)"
    aria-current="page"
    class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap"
    :class="[
        link.active
          ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
          : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
        i === 0 ? 'rounded-l-md' : '',
        i === data.links.length - 1 ? 'rounded-r-md' : '',
        !link.url ? ' bg-gray-100 text-gray-700': ''
      ]"
    v-html="link.label"
  >
  </a>
      </nav>
    </div>
  </div>
</template>

<script setup>
  import {computed, onMounted, ref} from "vue";
  import store from "../../store";
  import Toast from '../Toast.vue';
  import {EMPLOYEES_PER_PAGE} from "../../constants";
 
  import TableHeaderCell from "./TableHeaderCell.vue";
  import {Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
  import {DotsVerticalIcon, PencilIcon, TrashIcon} from '@heroicons/vue/outline'

import Spinner from "./Spinner.vue";
import Button from "./Button.vue";
import { useRouter } from "vue-router";

  const perPage = ref(EMPLOYEES_PER_PAGE);
  const search = ref('');

  const data = computed(() =>store.state[`${props.state}`]);
  const sortField = ref('updated_at');
  const sortDirection = ref('desc')
  const perPageOptions = ref( [
      { value: 5, label: '5' },
      { value: 10, label: '10' },
      { value: 15, label: '15' },
      { value: 20, label: '20' },
    ]);
  
    const sortedItems=computed(()=> {
    return this.items.sort((a, b) => {
      if (a[this.sortField] < b[this.sortField]) {
        return this.sortDirection === 'asc' ? -1 : 1
      } else if (a[this.sortField] > b[this.sortField]) {
        return this.sortDirection === 'asc' ? 1 : -1
      } else {
        return 0
      }
    })
  });

  const item = ref({})

  const showitemModal = ref(false);
  const router = useRouter();
  const emit = defineEmits(['clickEdit'])
  
  onMounted(() => {
    getitems();
  }) 
  const props = defineProps({
  createNewLabel: {
  type: String,
  default: 'Create New+',
},
noResultsLabel: {
  type: String,
},
title : {
  type: String,
},
state : {
  type: String,
},
headers:{
  type:Object,

},
perPageLabel: {
  type: String,
},
bgColorActiveClass: {
  type: String,
  default: 'bg-gray-900',
},
});
  function getForPage(ev, link) {
    ev.preventDefault();
    if (!link.url || link.active) {
      return;
    }
  
    getitems(link.url)
  }
 function sortItems (field) {
    if (field === this.sortField) {
      this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc'
    } else {
      this.sortField = field
      this.sortDirection = 'asc'
    }
  }

  
  function getitems(url = null) {
    store.dispatch("getitems", {
      url,
      search: search.value,
      per_page: perPage.value,
      sort_field: sortField.value,
      sort_direction: sortDirection.value
    });

  }
  
  function sortemployees(field) {
    if (field === sortField.value) {
      if (sortDirection.value === 'desc') {
        sortDirection.value = 'asc'
      } else {
        sortDirection.value = 'desc'
      }
    } else {
      sortField.value = field;
      sortDirection.value = 'asc'
    }
  
    getitems()
  }
  
  function showAddNewModal() {
    showitemModal.value = true
  }

  function isOdd(index) {
    return index % 2 !== 0
  }
  
  function deleteitem(item) {
  if (!confirm(`Are you sure you want to delete the employee?`)) {
    return
  }
  store.dispatch('deleteitem', item)
    .then(res => {
      // TODO Show notification
      store.dispatch('getitems')
      store.commit('showToast', `Employee  has been deleted successfully`)
    })
}

const redirectToRoute = () => {
  router.push(`/employees/create`); // replace with the actual route you want to navigate to
};

  </script>
  
  <style scoped>
  
  </style>
  