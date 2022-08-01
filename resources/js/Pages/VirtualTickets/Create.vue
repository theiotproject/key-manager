<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import CreateVirtualTicketForm from "./Partials/CreateVirtualTicketForm.vue";
</script>

<template>
    <AppLayout title="Create Team">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Send Virtual Ticket via email
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateVirtualTicketForm v-bind:attrs="localAttrs" />
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
