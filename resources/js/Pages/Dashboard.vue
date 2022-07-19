<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import GatesWidget from "./Widgets/GatesWidget.vue";
import VirtualKeysWidget from "./Widgets/VirtualKeysWidget.vue";
import UsersWidget from "./Widgets/UsersWidget.vue";
import EventsWidget from "./Widgets/EventsWidget.vue";
import HomeHeader from "../Components/Home/HomeHeader.vue";
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div
          class="grid grid-rows-w gap-x-5 gap-y-5"
          style="grid-template-columns: repeat(2, 1fr) 0.9fr"
        >
          <GatesWidget
            class="max-h-100"
            v-bind:attrs="attrs"
            style="grid-area: 1 / 1 / 2 / 2"
          />
          <UsersWidget
            class="max-h-100"
            v-bind:attrs="attrs"
            style="grid-area: 1 / 2 / 2 / 3"
          />
          <VirtualKeysWidget
            class="max-h-100"
            v-bind:attrs="attrs"
            style="grid-area: 2 / 1 / 3 / 3"
          />
          <EventsWidget
            class="max-h-100"
            v-bind:attrs="attrs"
            style="grid-area: 1 / 3 / 3 / 4;"
          />
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import GateShow from "./Gates/Show.vue";
import CreateGateForm from "./Gates/Partials/CreateGateForm.vue";

export default {
  components: {
    GateShow,
    CreateGateForm,
  },
  data() {
    return {
      component: "GateShow",
      attrs: this.$attrs,
    };
  },
  methods: {
    toggle() {
      if (this.component === "GateShow") {
        this.component = "CreateGateForm";
      } else {
        this.component = "GateShow";
      }
    },
  },
};
</script>
