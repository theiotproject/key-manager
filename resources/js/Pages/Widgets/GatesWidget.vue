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
                        fill-rule="evenodd"
                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                        clip-rule="evenodd"
                    />
                </svg>
                <p class="ml-3">Gates</p>
            </h2>
            <Link
                v-if="permission"
                :href="route('gates.create')"
                class="mr-10 mt-4 text-gray-600 hover:text-black rounded flex items-center gap-2"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                    <path
                        fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd"
                    />
                </svg>
                Add Gate
            </Link>
        </div>
        <div class="pb-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden sm:rounded-lg"
                    style="background-color: #f7f7f7"
                >
                    <div
                        class="relative overflow-x-auto shadow-md sm:rounded-lg"
                        style="background-color: #f7f7f7"
                    >
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead
                                class="text-xs text-white uppercase bg-gradient-to-r from-blue-500 to-sky-400"
                                v-if="!isSafari()"
                            >
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 sm:rounded l-lg sm:rounded-r-lg rounded-none"
                                    >
                                        Name
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
                                        class="px-6 py-3 sm:rounded l-lg sm:rounded-r-lg rounded-none"
                                    >
                                        Name
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class="border-b"
                                    v-for="(gate, index) in gates"
                                    :key="gate.id"
                                >
                                    <td
                                        v-if="index <= 3"
                                        class="lg:px-6 md:px-3 px-5 py-4 font-medium text-gray-900 whitespace-nowrap"
                                    >
                                        {{ gate.name }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div
                    class="h-64 w-full flex justify-center items-center"
                    v-if="gates.length <= 0"
                >
                    <p class="text-xl text-gray-600">
                        You don't have any Gates
                    </p>
                </div>
                <div
                    class="mt-5 w-full flex justify-center"
                    v-if="gates.length > 4"
                >
                    <Link
                        :href="route('gates.index')"
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
    name: "GatesWidget",
    props: ["attrs", "team"],
    data() {
        return {
            gates: {},
            permission: 0,
            localAttrs: this.attrs,
            localTeam: this.team,
        };
    },
    methods: {
        getGates() {
            axios
                .get(
                    `/gates/teamId/${this.localAttrs.user.current_team_id}/resource`
                )
                .then((response) => {
                    this.gates = response.data.data;
                });
        },
        getPermission() {
            axios
                .get(
                    `/auth/permission/teamId/${this.localAttrs.user.current_team_id}`
                )
                .then((response) => {
                    this.permission = response.data;
                });
        },
        isSafari() {
            return /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
        },
    },
    created() {
        this.isSafari();
        this.getGates();
        this.getPermission();
    },
};
</script>
