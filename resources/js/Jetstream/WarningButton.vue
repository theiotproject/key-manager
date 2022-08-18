<script setup>
defineProps({
    type: {
        type: String,
        default: "button",
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center justify-center px-4 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-500 focus:outline-none focus:border-orange-700 focus:ring focus:ring-orange-200 active:bg-orange-600 disabled:opacity-25 transition"
    >
        <slot />
    </button>
</template>
