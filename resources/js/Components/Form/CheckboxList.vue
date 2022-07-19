<script setup>
import JetLabel from "@/Jetstream/Label.vue";
</script>

<template>
    <JetLabel for="days" value="Days" />
    <ul
        class="items-center w-full text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 sm:flex-wrap sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white"
    >
        <li
            v-for="day in days"
            class="w-auto border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600"
        >
            <div class="flex items-center pl-3">
                <input
                    id="{{day}}-checkbox-list"
                    type="checkbox"
                    value=""
                    class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                />
                <label
                    for="{{day}}-checkbox-list"
                    class="py-3 ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-300"
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
        };
    },
};
</script>
