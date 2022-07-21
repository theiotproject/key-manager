<script setup>
import JetLabel from "@/Jetstream/Label.vue";
</script>

<template>
    <JetLabel value="Days" class="mb-3" />
    <ul
        class="items-center w-full font-medium text-gray-900 bg-white rounded-lg sm:flex-wrap sm:flex"
    >
        <li
            v-for="(day, index) in days"
            :key="index"
            class="w-auto sm:w-28 border rounded-lg m-0.5 border-gray-200 sm:border-r"
        >
            <div class="flex items-center pl-3">
                <input
                    v-model="checkedDays"
                    v-bind:id="index"
                    type="checkbox"
                    :value="index"
                    class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 focus:ring-2"
                />
                <label
                    v-bind:id="index"
                    class="py-2 ml-2 w-full text-xs font-medium text-gray-900"
                >
                    {{ day }}
                </label>
            </div>
        </li>
    </ul>
</template>
<script>
export default {
    data() {
        return {
            days: [
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday",
                "Saturday",
                "Sunday",
            ],
            checkedDays: [0, 1, 2, 3, 4],
        };
    },
};
</script>
