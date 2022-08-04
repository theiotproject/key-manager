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
            <button
                @click="getEvents; isEventNew = true;"
                class="mr-10 mt-4 hover:text-black text-gray-600 flex items-center gap-2"
            >

                <transition name="appear" @after-leave="isEventNew=false">
                    <span v-if="isEventNew" class="text-sm mx-3 text-gray-600">New events not found</span>
                    <span v-else class="absolute"></span>
                </transition>

                <transition name="rotation" @after-leave="showHello=true">
                <svg
                    v-if="showHello"
                    @click="showHello=false"
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                    />
                </svg>
                </transition>

            </button>
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
                                        class="px-3 py-3 sm:rounded-l-lg rounded-none"
                                    >
                                        User
                                    </th>
                                    <th scope="col" class="px-2 py-3">Gate</th>
                                    <th
                                        scope="col"
                                        class="px-2 py-3 sm:rounded-r-lg rounded-none"
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
                                        class="px-3 py-3 sm:rounded-l-lg rounded-none"
                                    >
                                        User
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3"
                                    >
                                        Gate
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-2 py-3 sm:rounded-r-lg rounded-none"
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
                                            ? 'text-green-800 bg-teal-50'
                                            : 'text-red-700 bg-red-50'
                                    "
                                    class="border-b"
                                >
                                    <td
                                        class="px-3 py-4 font-medium whitespace-nowrap"
                                    >
                                        <div class="flex items-center">
                                            <a
                                                :title="event.name"
                                                class="h-8 w-8 mr-2 cursor-pointer"
                                            >
                                                <img
                                                    class="rounded-full object-cover mr-1"
                                                    :src="
                                                        event.profile_photo_url
                                                    "
                                                />
                                            </a>
                                        </div>
                                    </td>
                                    <td
                                        class="px-2 py-4 font-medium whitespace-nowrap"
                                    >
                                        <span
                                            v-if="event.gate_name.length < 8"
                                            >{{ event.gate_name }}</span
                                        >
                                        <span v-else>{{
                                            event.gate_name.substring(0, 20) +
                                            ".."
                                        }}</span>
                                    </td>
                                    <td
                                        class="px-2 py-4 font-medium whitespace-nowrap"
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
                <!--                <div class="mt-5 w-full flex justify-center">-->
                <!--                    <Link-->
                <!--                        :href="route('events.index')"-->
                <!--                        class="-->
                <!--                        text-gray-600-->
                <!--                        hover:text-black-->
                <!--                        py-2-->
                <!--                        px-4-->
                <!--                        rounded">-->
                <!--                        Show all-->
                <!--                    </Link>-->
                <!--                </div>-->
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
            lastEventId: null,
            isEventNew: false,
            showHello: true,
            events: {},
            localAttrs: this.attrs,
        };
    },
    methods: {
        getEvents() {
            axios
                .get(
                    `/events/teamId/${this.localAttrs.user.current_team_id}/limit/10`
                )
                .then((response) => {
                    this.events = response.data;

                    // if(this.lastEventId!=null){
                    //
                    //     if(this.lastEventId!==this.events[this.events.length]){
                    //
                    //     }
                    //
                    // } else {
                    //
                    // }
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

<style>
.rotation-enter {
    transform: rotate(0);
}

.rotation-enter-active,
.rotation-leave-active{
    transition: all 1s ease-out;
}

.rotation-leave-to{
    transform: rotate(-360deg);
}

.appear-enter {
    opacity: 0;
}

.appear-enter-active,
.appear-leave-active{
    transition: all 3s cubic-bezier(0.68, 0.38, 0.68, 0.39);
}

.appear-leave-to{
    opacity: 0;
}

</style>
