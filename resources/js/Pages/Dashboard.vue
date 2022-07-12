<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12 relative">
                    <button v-if="component==='GateShow'" @click="toggle()" class=" bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded right-24 top-32 absolute">
                        Create New Gate
                    </button>
                    <component :is="component" v-bind:attrs="this.$attrs" />
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
            component:"GateShow"
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
