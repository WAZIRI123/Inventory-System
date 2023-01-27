
<script setup>
import CustomInput from '../components/CustomInput.vue';
import GuestLayout from '../components/GuestLayout.vue';

import CustomButton from '../components/CustomButton.vue';

</script>
<template>
   <GuestLayout title="login">
                <form method="POST" @submit.prevent="login">
                <div class="mt-4">
                <!-- start::Default Input -->
               <CustomInput/>
                <!-- end::Default Input -->
                </div>

                <div class="mt-4">
                <!-- start::Default Input -->
               <CustomInput/>
                <!-- end::Default Input -->
                </div>
                <div class="mt-4">
                <!-- start::Default Input -->
               <CustomInput type="checkbox"/>
                <!-- end::Default Input -->
                </div >

                <div class="mt-4">
                 <CustomButton title="login"/>
                </div>
            </form>
        </GuestLayout>

</template>

