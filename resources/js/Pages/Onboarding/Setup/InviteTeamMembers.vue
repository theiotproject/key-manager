<script setup>
</script>
<template>
  <div class="w-200">
    <p class="py-5">Step 2 of 3</p>
    <h1 class="text-4xl">Who else is on the {team.name} team</h1>
    <p class="py-3">Add teammate by email</p>
    <form>
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
        class="
          image
          bg-gradient-to-r
          from-blue-500
          to-sky-400
          p-2
          px-6
          my-3
          rounded
          text-white
          flex
          items-center
        "
      >
        Next
      </button>
    </form>
  </div>
</template>
<style scoped>
* {
  font-family: "montserrat";
}
</style>
