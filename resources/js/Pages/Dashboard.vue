<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
                    <GateShow v-bind:attrs="attrs" />
            </div>
    </AppLayout>
</template>

<script>
import GateShow from './gates/Show.vue';
import CreateGateForm from "./gates/Partials/CreateGateForm.vue";

export default {
    components: {
        GateShow,
        CreateGateForm
    },
    data (){
        return {
            component:"GateShow",
            attrs: this.$attrs
        }
    },
    methods: {
        toggle(){
            if (this.component === "GateShow") {
                this.component = "CreateGateForm";
            } else {
                this.component = "GateShow";
            }
        }
    }
}
</script>
