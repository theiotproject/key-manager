<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import JetConfirmationModal from "@/Jetstream/ConfirmationModal.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import MakeToast from "../../Services/MakeToast.vue";

const removeVirtualTicketForm = useForm();

const virtualTicketBeingRemoved = ref(null);

const confirmVirtualTicketRemoval = (virtualTicket) => {
    virtualTicketBeingRemoved.value = virtualTicket;
};

const removeVirtualTicket = () => {
    removeVirtualTicketForm.delete(
        route("virtualTickets.destroy", [virtualTicketBeingRemoved.value]),
        {
            errorBag: "removeVirtualTicket",
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                virtualTicketBeingRemoved.value = null;
            },
            onError: () => {
                MakeToast.create("Failed to delete Virtual Ticket", "error");
            },
        }
    );
};
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Virtual Tickets
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                                    d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <p class="ml-3">Virtual Tickets</p>
                        </h2>
                        <Link
                            v-if="role === 'admin' || role === 'owner'"
                            :href="route('virtualTicket.create')"
                            class="mr-10 mt-4 hover:text-black text-gray-600 flex items-center gap-2"
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
                            Create New Virtual Ticket
                        </Link>
                    </div>
                    <div class="pb-5">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden sm:rounded-lg">
                                <div
                                    class="relative overflow-x-auto shadow-md sm:rounded-lg"
                                >
                                    <table
                                        class="w-full text-sm text-left text-gray-500"
                                    >
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
                                                    class="lg:px-3 md:px-0"
                                                >
                                                    Label
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="lg:px-3 md:px-0"
                                                >
                                                    Expiration
                                                </th>

                                                <th
                                                    scope="col"
                                                    class="lg:px-3 md:px-0 sm:rounded-r-lg rounded-none"
                                                ></th>
                                            </tr>
                                        </thead>
                                        <thead
                                            class="text-xs text-white uppercase bg-blue-500 border-none"
                                            v-if="isSafari()"
                                        >
                                            <tr>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3 sm:rounded-l-lg border-none rounded-none"
                                                >
                                                    User
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="lg:px-3 md:px-0 border-none"
                                                >
                                                    Label
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="lg:px-3 md:px-0"
                                                >
                                                    Expiration
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="lg:px-3 md:px-0 sm:rounded-r-lg border-none rounded-none"
                                                ></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                class="bg-white border-b"
                                                v-for="virtualTicket in virtualTickets"
                                                :key="virtualTicket.id"
                                            >
                                                <td
                                                    class="lg:px-3 md:px-0 px-5 py-4 font-medium text-gray-900 whitespace-nowrap"
                                                >
                                                    <div
                                                        class="flex items-center"
                                                    >
                                                        <img
                                                            class="h-8 w-8 rounded-full object-cover mr-3"
                                                            :src="
                                                                virtualTicket.name !=
                                                                'unregistered'
                                                                    ? virtualTicket.profile_photo_url
                                                                    : 'https://ui-avatars.com/api/?name=?&color=7F9CF5&background=EBF4FF&font-size=0.6'
                                                            "
                                                            :alt="
                                                                virtualTicket.name
                                                            "
                                                        />
                                                        <div>
                                                            {{
                                                                virtualTicket.name
                                                            }}
                                                            <p
                                                                class="text-gray-400 text-xs"
                                                            >
                                                                {{
                                                                    virtualTicket.email
                                                                }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td
                                                    class="lg:px-3 md:px-0 py-4 font-medium text-gray-900 whitespace-nowrap"
                                                >
                                                    {{ virtualTicket.label }}
                                                </td>
                                                <td
                                                    class="lg:px-3 md:px-0 py-4 font-medium whitespace-nowrap"
                                                >
                                                    {{
                                                        timeAgo.format(
                                                            new Date(
                                                                virtualTicket.validTo
                                                            ),
                                                            { future: true }
                                                        )
                                                    }}
                                                </td>
                                                <td
                                                    class="lg:px-3 md:px-0 py-4 text-right font-medium text-gray-900 whitespace-nowrap"
                                                >
                                                    <button
                                                        v-if="
                                                            role === 'owner' ||
                                                            role === 'admin'
                                                        "
                                                        class="cursor-pointer ml-6 text-sm text-red-500 hover:text-red-700"
                                                        @click="
                                                            confirmVirtualTicketRemoval(
                                                                virtualTicket
                                                            );
                                                            selectTicketIndex(
                                                                virtualTicket.id
                                                            );
                                                        "
                                                    >
                                                        <svg
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
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                            />
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Remove Virtual Ticket Confirmation Modal -->
            <JetConfirmationModal
                :show="virtualTicketBeingRemoved !== null"
                @close="virtualTicketBeingRemoved = null"
            >
                <template #title> Remove Virtual Ticket </template>

                <template #content>
                    Are you sure you would like to remove this Virtual Ticket?
                </template>

                <template #footer>
                    <JetSecondaryButton
                        @click="virtualTicketBeingRemoved = null"
                    >
                        Cancel
                    </JetSecondaryButton>

                    <JetDangerButton
                        class="ml-3"
                        :class="{
                            'opacity-25': removeVirtualTicketForm.processing,
                        }"
                        :disabled="removeVirtualTicketForm.processing"
                        @click="
                            removeVirtualTicket();
                            deleteVirtualTicket();
                        "
                    >
                        Remove
                    </JetDangerButton>
                </template>
            </JetConfirmationModal>
        </div>
    </AppLayout>
</template>

<script>
import TimeAgo from "javascript-time-ago";
import en from "javascript-time-ago/locale/en";
TimeAgo.addLocale(en);
const timeAgo = new TimeAgo("en-US");

export default {
    name: "VirtualTicketShow",
    data() {
        return {
            virtualTicketIndex: 0,
            virtualTickets: {},
            role: "",
            attrs: this.$attrs,
        };
    },
    methods: {
        selectTicketIndex(index) {
            this.virtualTicketIndex = index;
        },
        deleteVirtualTicket() {
            this.virtualTickets = this.virtualTickets.filter(
                (virtualTicket) => {
                    return virtualTicket.id !== this.virtualTicketIndex;
                }
            );
            MakeToast.create("Deleted Virtual Ticket", "info");
        },
        getVirtualTickets() {
            axios
                .get(
                    `/virtualTickets/teamId/${this.attrs.user.current_team_id}/users/gates`
                )
                .then((response) => {
                    this.virtualTickets = response.data;
                })
                .catch((err) => {
                    MakeToast.create("Cannot load Virtual Tickets", "error");
                });
        },
        getRole() {
            axios
                .get(`/auth/role/teamId/${this.attrs.user.current_team_id}`)
                .then((response) => {
                    this.role = response.data;
                })
                .catch((err) => {
                    MakeToast.create("Failed to get role", "error");
                });
        },
        isSafari() {
            return /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
        },
    },
    created() {
        this.isSafari();
        this.getVirtualTickets();
        this.getRole();
    },
};
</script>
