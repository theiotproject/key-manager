<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import MakeToast from "../../Services/MakeToast.vue";
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
                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                        clip-rule="evenodd"
                    />
                </svg>
                <p class="ml-3">Events</p>
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
      Go to events
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
                                        User
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 sm:rounded-l-lg rounded-none"
                                    >
                                        Gate
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 sm:rounded-l-lg rounded-none"
                                    >
                                        Date
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 sm:rounded-r-lg rounded-none"
                                    >
                                        Message
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
                                        User
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 sm:rounded-l-lg rounded-none"
                                    >
                                        Gate
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 sm:rounded-l-lg rounded-none"
                                    >
                                        Date
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 sm:rounded-r-lg rounded-none"
                                    >
                                        Message
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="event in events"
                                    :key="event.id"
                                    v-bind:class="
                                        event.status
                                            ? 'text-red-700'
                                            : 'text-green-700'
                                    "
                                    class="bg-white border-b"
                                >
                                    <td
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                                    >
                                        {{ event.name }}
                                    </td>
                                    <td
                                        class="px-6 py-4 font-medium whitespace-nowrap"
                                    >
                                        {{ event.gate_name }}
                                    </td>
                                    <td
                                        class="px-6 py-4 font-medium whitespace-nowrap"
                                    >
                                        {{ event.scan_time }}
                                    </td>
                                    <td
                                        class="px-6 py-4 font-medium whitespace-nowrap"
                                    >
                                        {{ event.message }}
                                    </td>
                                    <!-- <td
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                                    >
                                        {{ event.name }}
                                    </td> -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "EventsWidget",
    props: ["attrs"],
    data() {
        return {
            events: {},
            attrs: this.attrs,
        };
    },
    methods: {
        getEvents() {
            axios
                .get(`/events/teamId/${this.attrs.user.current_team_id}`)
                .then((response) => {
                    this.events = response.data;
                })
                .catch((err) => {
                    MakeToast.create("Cannot load Events", "error");
                });
        },
        isSafari() {
            return /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
        },
    },
    created() {
        this.isSafari();
        this.getEvents();
    },
};
</script>
