<script setup>

import {useForm} from "@inertiajs/inertia-vue3";

const props = defineProps(["team"]);

const form = useForm({
    name: props.team.name
});

const updateTeamName = () => {
    form.put(route("teams.update", props.team), {
        errorBag: "updateTeamName",
        preserveScroll: true,
    })
};
</script>
<template>
  <form @submit.prevent="$emit('submit')">
    <div class="w-200 mt-44 py-5 bg-white sm:p-6 shadow">
      <p class="py-5">Step 1 of 3</p>
      <h1 class="text-4xl">What's the name of your company or team?</h1>
      <p class="py-3">
        This will be the name of your Key Manager workspace — choose something
        that your team will recognize.
      </p>
      <input
        v-model="form.name"
        class="
          border-gray-300
          focus:border-indigo-300
          focus:ring
          focus:ring-indigo-200
          focus:ring-opacity-50
          rounded-md
          shadow-sm
          w-full
        "
        type="text"
      />
    </div>
    <div
      class="
        flex
        items-center
        justify-end
        text-right
        bg-gray-50
        shadow
        pb-5
        px-6
        sm:rounded-bl-md sm:rounded-br-md
      "
    >
      <button
        @click="updateTeamName();nextStep()"
        class="
          mt-5
          inline-flex
          items-center
          px-8
          py-2
          bg-gray-800
          border border-transparent
          rounded-md
          font-semibold
          text-xs text-white
          uppercase
          tracking-widest
          hover:bg-gray-700
          active:bg-gray-900
          focus:outline-none
          focus:border-gray-900
          focus:ring
          focus:ring-gray-300
          disabled:opacity-25
          transition
        "
      >
        Next
      </button>
    </div>
  </form>
</template>
<script>
export default {
  props: ["attrs", "team"],
  data() {
    return {
      attrs: this.attrs,
      // team: this.team,
    };
  },
  methods: {
    nextStep() {
      this.$emit('nextStep');
    },
    // updateTeamName() {
    //     console.log(this.team);
    //   form.put(route("teams.update", this.team), {
    //     errorBag: "updateTeamName",
    //     preserveScroll: true,
    //   });
    // },
  },
};
</script>
<style scoped>
* {
  font-family: "montserrat";
}
</style>
