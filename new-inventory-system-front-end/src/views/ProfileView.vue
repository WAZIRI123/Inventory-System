<template>
    <div class="h-full bg-gray-200 p-8">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
               
            </h2>
        </x-slot>
    
        <div class="py-12">
            Profile   {{ update   }}
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                       <UpdateProfileInformation @user:updated="updateMessage"/>
                    </div>
                </div>
    
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')

                    </div>
                </div>
    
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
        </div>
</template>

<script setup>
import { ref } from 'vue';
import UpdateProfileInformation from '../components/profile/UpdateProfileInformation.vue';
  
let update=ref('');

function updateMessage(message){
    update.value=message

}

</script>