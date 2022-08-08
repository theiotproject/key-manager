<template>


  <div class="w-200">
    <p class="py-5">Step 1 of 3</p>
    <h1 class="text-4xl">What's the name of your company or team?</h1>
    <p class="py-3">
      This will be the name of your Key Manager workspace — choose something
      that your team will recognize.
    </p>
    <form @submit.prevent="$emit('submit')">
      <input
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
      <button
        @click="nextStep"
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
    </form>
  </div>
</template>
<script>
export default {
  props: ["nextStep"],
  methods: {
    nextStep() {
      this.nextStep();
    },
  },
};
</script>
<style scoped>
* {
  font-family: "montserrat";
}
</style>
