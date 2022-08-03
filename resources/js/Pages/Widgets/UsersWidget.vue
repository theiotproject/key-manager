<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
</script>
<template>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="flex justify-between">
            <h2
                class="m-7 py-2 text-gray-900 font-bold text-xl mb-2 flex items-center"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 ml-2"
                    viewBox="0 0 20 20"
                    fill="#FFA500"
                >
                    <path
                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"
                    />
                </svg>
                <p class="ml-3">Team members</p>
            </h2>
            <!-- <Link
        :href="route('gates.index')"
        class="
          m-7
          bg-blue-500
          hover:bg-blue-700
          text-white
          font-bold
          py-2
          px-4
          rounded
        "
      >
        Go to users page
      </Link> -->
        </div>
        <div class="pb-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden sm:rounded-lg">
                    <div
                        class="relative overflow-x-auto shadow-md sm:rounded-lg"
                    >
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead
                                class="text-xs text-white uppercase bg-gradient-to-r from-blue-500 to-sky-400"
                                v-if="!isSafari()"
                            >
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 sm:rounded-l-lg rounded-none"
                                    >
                                        Name
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 sm:rounded-r-lg rounded-none"
                                    >
                                        Role
                                    </th>
                                </tr>
                            </thead>
                            <thead
                                class="text-xs text-white uppercase bg-blue-500"
                                v-if="isSafari()"
                            >
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 sm:rounded-l-lg rounded-none"
                                    >
                                        Name
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 sm:rounded-r-lg rounded-none"
                                    >
                                        Role
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class="bg-white border-b"
                                    v-for="(user, index) in users"
                                    :key="user.id"
                                >
                                    <td
                                        v-if="index <= 2"
                                        class="lg:px-3 md:px-0 px-5 py-4 font-medium text-gray-900 whitespace-nowrap"
                                    >
                                        <div class="flex items-center">
                                            <img
                                                class="h-8 w-8 rounded-full object-cover mr-3"
                                                :src="user.profile_photo_url"
                                                :alt="user.name"
                                            />
                                            <div>
                                                {{ user.name }}
                                                <p
                                                    class="text-gray-400 text-xs"
                                                >
                                                    {{ user.email }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td
                                        v-if="index <= 2"
                                        class="lg:px-3 md:px-0 py-4 font-medium text-gray-900 whitespace-nowrap"
                                    >
                                        <p
                                            v-if="
                                                user.membership.role == 'owner'
                                            "
                                            class="font-bold"
                                        >
                                            Owner
                                        </p>
                                        <p
                                            v-if="
                                                user.membership.role == 'admin'
                                            "
                                            class="font-bold"
                                        >
                                            Administrator
                                        </p>
                                        <p
                                            v-if="
                                                user.membership.role == 'user'
                                            "
                                        >
                                            Member
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div
                    class="mt-5 w-full flex justify-center"
                    v-if="users.length > 3"
                >
                    <Link
                        class="text-gray-600 hover:text-black py-2 px-4 rounded"
                    >
                        Show more
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "UsersWidget",
    props: ["attrs"],
    data() {
        return {
            users: {},
            localAttrs: this.attrs,
        };
    },
    methods: {
        getUsers() {
            axios
                .get(`/auth/users/${this.localAttrs.user.current_team_id}`)
                .then((response) => {
                    this.users = response.data;
                });
        },
        isSafari() {
            return /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
        },
    },
    created() {
        this.isSafari();
        this.getUsers();
    },
};
</script>
