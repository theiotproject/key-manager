<script setup>
import JetLabel from "@/Jetstream/Label.vue";
import SearchBar from "./Partials/SearchBar.vue";
</script>

<template>
    <JetLabel for="users" value="Users" />
    <SearchBar />
    <ul
        class="overflow-y-auto px-3 pb-3 h-48 text-sm text-gray-700 dark:text-gray-200"
        aria-labelledby="dropdownSearchButton"
    >
        <li v-for="(user, index) in users" :key="index">
            <div
                class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
            >
                <input
                    v-bind:id="index"
                    type="checkbox"
                    value=""
                    class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                />
                <label
                    for="{{index}}"
                    class="ml-2 w-full text-sm font-medium text-gray-900 rounded dark:text-gray-300"
                    >{{ user.name }}</label
                >
            </div>
        </li>
    </ul>
</template>
<script>
export default {
    name: "UsersList",
    props: ["attrs"],
    data() {
        return {
            users: {},
        };
    },
    methods: {
        getUsers() {
            axios
                .get(`/auth/users/${this.attrs.user.current_team_id}`)
                .then((response) => {
                    this.users = response.data;
                });
        },
    },
    created() {
        this.getUsers();
    },
};
</script>
