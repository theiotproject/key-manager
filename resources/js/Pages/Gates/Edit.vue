<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import EditGateForm from "@/Pages/Gates/Partials/EditGateForm.vue";
import { usePage } from "@inertiajs/inertia-vue3";
const gate = usePage().props.value.gate;
</script>

<template>
    <AppLayout title="Edit Gate">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Gate
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <EditGateForm v-bind:attrs="attrs" :gate="gate" />
            </div>
        </div>
    </AppLayout>
</template>

<script>
export default {
    data() {
        return {
            attrs: this.$attrs,
        };
    },
};
</script>
