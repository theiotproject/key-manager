<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import CreateGateForm from "@/Pages/Gates/Partials/CreateGateForm.vue";
</script>

<template>
    <AppLayout title="Create Gate">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create New Gate
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateGateForm v-bind:attrs="attrs" :createVirtualKey="createVirtualKey"/>
            </div>
        </div>
    </AppLayout>
</template>

<script>
export default {
    props: ['createVirtualKey'],
    data() {
        console.log(this.createVirtualKey);
        return {
            attrs: this.$attrs,
            createVirtualKey: this.createVirtualKey
        };
    },
};
</script>
