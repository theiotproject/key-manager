<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import EditVirtualKeyForm from '@/Pages/VirtualKeys/Partials/EditVirtualKeyForm.vue';
import {usePage} from "@inertiajs/inertia-vue3";
const virtualKey = usePage().props.value.virtualKey;
</script>

<template>
    <AppLayout title="Create Team">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Virtual Key
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <EditVirtualKeyForm v-bind:attrs="attrs" :virtualKey="virtualKey"/>
            </div>
        </div>
    </AppLayout>
</template>

<script>
export default{
    data (){
        return {
            attrs: this.$attrs
        }
    },
}

</script>
