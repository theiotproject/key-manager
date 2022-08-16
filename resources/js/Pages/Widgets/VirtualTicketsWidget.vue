<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import JetModal from "@/Jetstream/DialogModal.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
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
                        d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z"
                        clip-rule="evenodd"
                    />
                </svg>
                <p class="ml-3">Virtual Tickets</p>
                <button
                    @click="switchList"
                    class="ml-2 text-gray-500 text-sm hover:text-gray-700"
                >
                    / Virtual Keys
                </button>
            </h2>
            <Link
                v-if="permission"
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
                                        class="lg:px-3 md:px-0 py-3 px-5"
                                    >
                                        Label
                                    </th>
                                    <th scope="col" class="lg:px-3 md:px-0">
                                        Expiration
                                    </th>
                                    <th
                                        scope="col"
                                        class="lg:px-3 md:px-0 py-3 px-5 sm:rounded-r-lg rounded-none"
                                    ></th>
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
                                        class="lg:px-3 md:px-0 py-3"
                                    >
                                        Label
                                    </th>
                                    <th scope="col" class="lg:px-3 md:px-0">
                                        Expiration
                                    </th>
                                    <th
                                        scope="col"
                                        class="lg:px-3 md:px-0 py-3 sm:rounded-r-lg rounded-none"
                                    ></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class="bg-white border-b"
                                    v-for="(
                                        virtualTicket, index
                                    ) in usersVirtualTickets"
                                    :key="virtualTicket.id"
                                >
                                    <td
                                        v-if="index <= 2"
                                        class="lg:px-3 md:px-0 px-5 py-4 font-medium text-gray-900 whitespace-nowrap"
                                    >
                                        <div class="flex items-center">
                                            <img
                                                class="h-8 w-8 rounded-full object-cover mr-3"
                                                :src="
                                                    virtualTicket.name !=
                                                    'unregistered'
                                                        ? virtualTicket.profile_photo_url
                                                        : 'https://ui-avatars.com/api/?name=?&color=7F9CF5&background=EBF4FF&font-size=0.6'
                                                "
                                                :alt="virtualTicket.name"
                                            />
                                            <div>
                                                {{ virtualTicket.name }}
                                                <p
                                                    class="text-gray-400 text-xs"
                                                >
                                                    {{ virtualTicket.email }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td
                                        v-if="index <= 2"
                                        class="lg:px-3 md:px-0 py-4 font-medium text-gray-900 whitespace-nowrap"
                                    >
                                        {{ virtualTicket.label }}
                                    </td>
                                    <td
                                        v-if="index <= 2"
                                        class="lg:px-3 md:px-0 py-4 font-medium whitespace-nowrap"
                                    >
                                        {{
                                            timeAgo.format(
                                                new Date(virtualTicket.validTo),
                                                { future: true }
                                            )
                                        }}
                                    </td>
                                    <td
                                        v-if="index <= 2"
                                        class="lg:px-3 md:px-0 py-4 font-medium text-gray-900 whitespace-nowrap"
                                    >
                                        <button
                                            class="ml-6 text-sm text-blue-500 hover:text-blue-700 flex items-center"
                                            @click="
                                                generateQrCode(virtualTicket)
                                            "
                                        >
                                            <p>Show QR Code</p>
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 mx-1"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"
                                                />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr
                                    class="bg-white border-b"
                                    v-for="(
                                        virtualTicket, index
                                    ) in notUsersVirtualTickets"
                                    :key="virtualTicket.id"
                                >
                                    <td
                                        v-if="
                                            usersVirtualTickets.length + index <
                                            3
                                        "
                                        class="lg:px-3 md:px-0 px-5 py-4 font-medium text-gray-900 whitespace-nowrap"
                                    >
                                        <div class="flex items-center">
                                            <img
                                                class="h-8 w-8 rounded-full object-cover mr-3"
                                                :src="
                                                    virtualTicket.profile_photo_url
                                                "
                                                :alt="virtualTicket.name"
                                            />
                                            <div>
                                                {{ virtualTicket.name }}
                                                <p
                                                    class="text-gray-400 text-xs"
                                                >
                                                    {{ virtualTicket.email }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td
                                        v-if="
                                            usersVirtualTickets.length + index <
                                            3
                                        "
                                        class="lg:px-3 md:px-0 py-4 font-medium text-gray-900 whitespace-nowrap"
                                    >
                                        {{ virtualTicket.label }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div
                    class="mt-5 w-full flex justify-center"
                    v-if="virtualTickets.length > 3"
                >
                    <Link
                        :href="route('virtualTickets.index')"
                        class="text-gray-600 hover:text-black py-2 px-4 rounded"
                    >
                        Show more
                    </Link>
                </div>
            </div>
        </div>
        <JetModal
            :show="showQrCode"
            @close="
                showQrCode = null;
                timer = false;
                qrCodeReady = false;
            "
        >
            <template #title> {{ usedVirtualTicket }} </template>

            <template #content v-if="qrCodeReady && validDay && qrCodeValid">
                <p class="py-5">
                    This code will expire in: {{ usedVirtualTicketDate }}
                </p>
                <qrcode-vue :value="qrCode.value" :size="300" level="H" />
            </template>
            <template #content v-else-if="!qrCodeValid">
                <p class="py-5">Cannot generate QR Code</p>
            </template>
            <template #content v-else-if="!validDay">
                <p class="py-5">Day is not valid</p>
            </template>
            <template #content v-else>
                <p class="py-5">Loading...</p>
            </template>

            <template #footer>
                <JetSecondaryButton
                    @click="
                        showQrCode = null;
                        timer = false;
                        qrCodeReady = false;
                    "
                >
                    Cancel
                </JetSecondaryButton>
            </template>
        </JetModal>
    </div>
</template>
<script>
import TimeAgo from "javascript-time-ago";
import en from "javascript-time-ago/locale/en";
TimeAgo.addLocale(en);
const timeAgo = new TimeAgo("en-US");

import QrcodeVue from "qrcode.vue";
import sha256 from "js-sha256";

export default {
    name: "VirtualTicketWidget",
    props: ["attrs"],
    data() {
        return {
            qrCode: {
                value: "",
                size: 250,
            },
            validDay: true,
            qrCodeReady: false,
            showQrCode: false,
            qrCodeValid: false,
            timer: false,
            countDown: 60,
            usedVirtualTicket: "",
            usedVirtualTicketDate: "",
            gates: {},
            virtualTickets: {},
            permission: 0,
            localAttrs: this.attrs,
        };
    },
    methods: {
        switchList() {
            this.$emit("switch", true);
        },
        getVirtualTickets() {
            axios
                .get(
                    `/virtualTickets/teamId/${this.localAttrs.user.current_team_id}/users/gates`
                )
                .then((response) => {
                    this.virtualTickets = response.data;
                })
                .catch((error) => {
                    console.log(error);
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
        async generateQrCode(virtualTicket) {
            this.usedVirtualTicket = virtualTicket.label;
            this.usedVirtualTicketDate = virtualTicket.validTo;
            this.showQrCode = true;

            this.qrCodeReady = true;

            const gateSerialNumbers = Array.from(virtualTicket.gates)
                .map((gate) => gate.serial_number)
                .toString();
            const data = {
                id: virtualTicket.guid,
                virtual_ticket_id: virtualTicket.id,
                access_granted: 1,
                message: "ACCESS GRANTED",
            };

            var teamCode;

            await axios
                .get(
                    `/api/teams/code/ticket/${this.localAttrs.user.current_team_id}/${virtualTicket.id}`
                )
                .then((response) => {
                    teamCode = response.data;

                    var qrCode = `OPEN:ID:${virtualTicket.guid};VF:${virtualTicket.validFrom};VT:${virtualTicket.validTo};L:${gateSerialNumbers};;`;
                    var hashQrCode = sha256(qrCode + teamCode);
                    var finalQrCode = qrCode + "S:" + hashQrCode + ";";
                    this.qrCode.value = finalQrCode;
                    this.qrCodeValid = true;
                })
                .catch((err) => {
                    MakeToast.create("Cannot generate QR Code", "error");
                    this.qrCodeValid = false;
                    return;
                });
        },
        generateGuid() {
            return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, (c) =>
                (
                    c ^
                    (crypto.getRandomValues(new Uint8Array(1))[0] &
                        (15 >> (c / 4)))
                ).toString(16)
            );
        },
    },
    computed: {
        usersVirtualTickets: function () {
            return Array.from(this.virtualTickets).filter((virtualTicket) => {
                return virtualTicket.email === this.localAttrs.user.email;
            });
        },
        notUsersVirtualTickets: function () {
            return Array.from(this.virtualTickets).filter((virtualTicket) => {
                return virtualTicket.email !== this.localAttrs.user.email;
            });
        },
    },
    created() {
        this.isSafari();
        this.getVirtualTickets();
        this.getPermission();
    },
};
</script>
