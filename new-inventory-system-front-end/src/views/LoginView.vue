
<script setup>
import CustomInput from '../components/CustomInput.vue';

</script>
<template>
    <div class="h-full bg-gray-200 p-8">
        <!-- start::Default Inputs -->
        <div class="bg-white p-4 rounded-lg shadow-xl space-y-4 py-8">
            <h4 class="text-xl capitalize">Default Inputs</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- start::Default Input -->
               <CustomInput/>
                <!-- end::Default Input -->

                <!-- start::Default Input -->
                <CustomInput/>
                <!-- end::Default Input -->

                <!-- start::Default Input -->
                <CustomInput/>
                <!-- end::Default Input -->
            </div>
        </div>
        <!-- end::Default Inputs -->
    </div>

</template>