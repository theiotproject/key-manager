<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import CreateVirtualKeyForm from "./Partials/CreateVirtualKeyForm.vue";
</script>

<template>
    <AppLayout title="Create Virtual Key">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create New Virtual Key
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateVirtualKeyForm v-bind:attrs="localAttrs" />
            </div>
        </div>
    </AppLayout>
</template>

<script>
export default {
    name: "Create",
    props: ["attrs"],

    data() {
        return {
            localAttrs: this.$attrs,
        };
    },
};
</script>
