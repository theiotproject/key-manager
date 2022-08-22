<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import JetConfirmationModal from "@/Jetstream/ConfirmationModal.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetModal from "@/Jetstream/DialogModal.vue";
import MakeToast from "../../Services/MakeToast.vue";

const removeVirtualKeyForm = useForm();

const virtualKeyBeingRemoved = ref(null);

const confirmVirtualKeyRemoval = (virtualKey) => {
    virtualKeyBeingRemoved.value = virtualKey;
};

const removeVirtualKey = () => {
    removeVirtualKeyForm.delete(
        route("virtualKeys.destroy", [virtualKeyBeingRemoved.value]),
        {
            errorBag: "removeVirtualKey",
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                virtualKeyBeingRemoved.value = null;
                MakeToast.create("Deleted Virtual Key", "info");
            },
            onError: () => {
                MakeToast.create("Failed to delete Virtual Key", "error");
            },
        }
    );
};
</script>

<template>
    <AppLayout title="Virtual Keys">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Virtual Keys
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
                            <p class="ml-3">Virtual Keys</p>
                        </h2>
                        <Link
                            v-if="role === 'owner' || role === 'admin'"
                            :href="route('virtualKey.create')"
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
                            Create New Virtual Key
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
                                                    Valid days
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
                                                    Valid days
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
                                                v-for="(
                                                    virtualKey, index
                                                ) in usersVirtualkeys"
                                                :key="virtualKey.id"
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
                                                                virtualKey.user
                                                                    .profile_photo_url
                                                            "
                                                            :alt="
                                                                virtualKey.user
                                                                    .name
                                                            "
                                                        />
                                                        <div>
                                                            {{
                                                                virtualKey.user
                                                                    .name
                                                            }}
                                                            <p
                                                                class="text-gray-400 text-xs"
                                                            >
                                                                {{
                                                                    virtualKey
                                                                        .user
                                                                        .email
                                                                }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td
                                                    class="lg:px-3 md:px-0 py-4 font-medium text-gray-900 whitespace-nowrap"
                                                >
                                                    {{ virtualKey.label }}
                                                </td>
                                                <td
                                                    class="lg:px-3 md:px-0 py-4 font-medium text-sm text-gray-900 whitespace-nowrap"
                                                >
                                                    <span
                                                        v-for="(
                                                            keyDay, i
                                                        ) in keyDays[index]"
                                                        :key="i"
                                                        >{{ keyDay }}&nbsp;
                                                    </span>
                                                </td>
                                                <td
                                                    class="lg:px-3 md:px-0 py-4 mt-2 text-right font-medium text-gray-900 whitespace-nowrap flex items-center justify-end"
                                                >
                                                    <button
                                                        class="ml-6 text-sm text-blue-500 hover:text-blue-700 flex items-center"
                                                        @click="
                                                            generateQrCode(
                                                                virtualKey
                                                            )
                                                        "
                                                    >
                                                        <p>Generate QR Code</p>
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
                                                    <Link
                                                        v-if="
                                                            role === 'owner' ||
                                                            role === 'admin'
                                                        "
                                                        class="cursor-pointer ml-6 text-sm text-blue-500 hover:text-blue-700"
                                                        :href="
                                                            route(
                                                                'virtualKeys.edit',
                                                                [virtualKey]
                                                            )
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
                                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                                                            />
                                                        </svg>
                                                    </Link>
                                                    <button
                                                        v-if="
                                                            role === 'owner' ||
                                                            role === 'admin'
                                                        "
                                                        class="cursor-pointer ml-6 text-sm text-red-500 hover:text-red-700"
                                                        @click="
                                                            confirmVirtualKeyRemoval(
                                                                virtualKey
                                                            )
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
                                            <tr
                                                class="bg-white border-b"
                                                v-for="(
                                                    virtualKey, index
                                                ) in notUsersVirtualKeys"
                                                :key="virtualKey.id"
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
                                                                virtualKey.user
                                                                    .profile_photo_url
                                                            "
                                                            :alt="
                                                                virtualKey.user
                                                                    .name
                                                            "
                                                        />
                                                        <div>
                                                            {{
                                                                virtualKey.user
                                                                    .name
                                                            }}
                                                            <p
                                                                class="text-gray-400 text-xs"
                                                            >
                                                                {{
                                                                    virtualKey
                                                                        .user
                                                                        .email
                                                                }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td
                                                    class="lg:px-3 md:px-0 py-4 font-medium text-gray-900 whitespace-nowrap"
                                                >
                                                    {{ virtualKey.label }}
                                                </td>
                                                <td
                                                    class="lg:px-3 md:px-0 py-4 font-medium text-sm text-gray-900 whitespace-nowrap"
                                                >
                                                    <span
                                                        v-for="(
                                                            keyDay, i
                                                        ) in keyDays[index]"
                                                        :key="i"
                                                        >{{ keyDay }}&nbsp;
                                                    </span>
                                                </td>
                                                <td
                                                    class="lg:px-3 md:px-0 py-4 mt-2 text-right font-medium text-gray-900 whitespace-nowrap flex items-center justify-end"
                                                >
                                                    <Link
                                                        v-if="
                                                            role === 'owner' ||
                                                            role === 'admin'
                                                        "
                                                        class="cursor-pointer ml-6 text-sm text-blue-500 hover:text-blue-700"
                                                        :href="
                                                            route(
                                                                'virtualKeys.edit',
                                                                [virtualKey]
                                                            )
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
                                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                                                            />
                                                        </svg>
                                                    </Link>
                                                    <button
                                                        v-if="
                                                            role === 'owner' ||
                                                            role === 'admin'
                                                        "
                                                        class="cursor-pointer ml-6 text-sm text-red-500 hover:text-red-700"
                                                        @click="
                                                            confirmVirtualKeyRemoval(
                                                                virtualKey
                                                            )
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

            <!-- Remove Virtual Key Confirmation Modal -->
            <JetConfirmationModal
                :show="virtualKeyBeingRemoved !== null"
                @close="virtualKeyBeingRemoved = null"
            >
                <template #title> Remove Virtual Key </template>

                <template #content>
                    Are you sure you would like to remove this virtual key?
                </template>

                <template #footer>
                    <JetSecondaryButton @click="virtualKeyBeingRemoved = null">
                        Cancel
                    </JetSecondaryButton>

                    <JetDangerButton
                        class="ml-3"
                        :class="{
                            'opacity-25': removeVirtualKeyForm.processing,
                        }"
                        :disabled="removeVirtualKeyForm.processing"
                        @click="removeVirtualKey"
                    >
                        Remove
                    </JetDangerButton>
                </template>
            </JetConfirmationModal>
            <JetModal
                :show="showQrCode"
                @close="
                    showQrCode = null;
                    timer = false;
                    qrCodeReady = false;
                "
            >
                <template #title> {{ usedVirtualKey }} </template>

                <template
                    #content
                    v-if="qrCodeReady && validDay && qrCodeValid"
                >
                    <p class="py-5">
                        This code will expire in: {{ countDown.toFixed(1) }}
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
    </AppLayout>
</template>

<script>
import QrcodeVue from "qrcode.vue";
import sha256 from "js-sha256";

export default {
    name: "VirtualKeyShow",
    data() {
        return {
            qrCode: {
                value: "",
                size: 250,
            },
            validDay: false,
            qrCodeReady: false,
            showQrCode: false,
            qrCodeValid: false,
            timer: false,
            countDown: 60,
            usedVirtualKey: "",
            gates: {},
            editHover: false,
            virtualKeys: {},
            role: "",
            attrs: this.$attrs,
            keyDays: [],
        };
    },
    methods: {
        getVirtualKeys() {
            axios
                .get(
                    `/virtualKeys/teamId/${this.attrs.user.current_team_id}/users/gates`
                )
                .then((response) => {
                    this.virtualKeys = response.data;
                    this.virtualKeys.forEach((virtualKey) => {
                        let days = [];
                        [...virtualKey.valid_days].forEach((day) => {
                            day === "U" ? days.push("Sun.") : "";
                            day === "M" ? days.push("Mon.") : "";
                            day === "T" ? days.push("Tue.") : "";
                            day === "W" ? days.push("Wed.") : "";
                            day === "R" ? days.push("Thu.") : "";
                            day === "F" ? days.push("Fri.") : "";
                            day === "S" ? days.push("Sat.") : "";
                        });
                        this.keyDays.push(days);

                        // const weekdayMap = new Map();
                        // weekdayMap.set("Sun.", "U");
                        // weekdayMap.set("Mon.", "M");
                        // weekdayMap.set("Tue.", "T");
                        // weekdayMap.set("Wed.", "W");
                        // weekdayMap.set("Thu.", "R");
                        // weekdayMap.set("Fri.", "F");
                        // weekdayMap.set("Sat.", "S");
                        // this.validDay = virtualKey.valid_days.includes(
                        //     weekdayMap.get(weekday)
                        // );
                    });
                    console.log(this.keyDays);
                })
                .catch((err) => {
                    // MakeToast.create("Cannot load Virtual Keys", "error");
                });
        },
        getRole() {
            axios
                .get(`/auth/role/teamId/${this.attrs.user.current_team_id}`)
                .then((response) => {
                    this.role = response.data;
                })
                .catch((err) => {
                    // MakeToast.create("Cannot load role", "error");
                });
        },
        isSafari() {
            return /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
        },
        async generateQrCode(virtualKey) {
            this.usedVirtualKey = virtualKey.label;
            this.countDown = 60;
            this.showQrCode = true;
            const currentDate = new Date();
            const weekday = currentDate.getDay();
            const weekdayMap = new Map();
            weekdayMap.set(0, "U");
            weekdayMap.set(1, "M");
            weekdayMap.set(2, "T");
            weekdayMap.set(3, "W");
            weekdayMap.set(4, "R");
            weekdayMap.set(5, "F");
            weekdayMap.set(6, "S");
            this.validDay = virtualKey.valid_days.includes(
                weekdayMap.get(weekday)
            );
            if (!this.validDay) {
                return 0;
            }
            await axios
                .get(`/api/gates/virtualKeyId/${virtualKey.id}`)
                .then((response) => {
                    this.gates = response.data;
                })
                .catch((err) => {
                    // MakeToast.create("Cannot load gates", "error");
                });
            this.qrCodeReady = true;
            const validFrom =
                currentDate.toISOString().slice(0, 10) +
                " " +
                currentDate.getHours() +
                ":" +
                (currentDate.getMinutes() < 10 ? "0" : "") +
                currentDate.getMinutes() +
                ":" +
                (currentDate.getSeconds() < 10 ? "0" : "") +
                currentDate.getSeconds();
            const validTo =
                currentDate.toISOString().slice(0, 10) +
                " " +
                currentDate.getHours() +
                ":" +
                (currentDate.getMinutes() < 9
                    ? "0" + (currentDate.getMinutes() + 1)
                    : currentDate.getMinutes() === 59
                    ? "00"
                    : currentDate.getMinutes() + 1) +
                ":" +
                (currentDate.getSeconds() < 10 ? "0" : "") +
                currentDate.getSeconds();
            const gateSerialNumbers = Array.from(this.gates)
                .map((gate) => gate.serial_number)
                .toString();
            const guid = this.generateGuid();
            var qrCode =
                "OPEN:ID:" +
                guid +
                ";VF:" +
                validFrom +
                ";VT:" +
                validTo +
                ";L:" +
                gateSerialNumbers +
                ";;";
            this.timer = true;
            this.countDownTimer();
            const data = {
                id: guid,
                virtual_key_id: virtualKey.id,
                access_granted: 1,
                message: "ACCESS GRANTED",
            };
            axios
                .post("/api/keyUsages", data)
                .then((response) => {
                    this.dataId = response.data.id;
                })
                .catch((err) => {
                    MakeToast.create("Cannot create key usage", "error");
                });

            var teamCode = "";
            await axios
                .get(
                    `/api/teams/code/${this.attrs.user.current_team_id}/${virtualKey.id}`
                )
                .then((response) => {
                    teamCode = response.data;

                    var hashQrCode = sha256(qrCode + teamCode);
                    var finalQrCode = qrCode + "S:" + hashQrCode + ";";
                    this.qrCode.value = finalQrCode;
                    this.qrCodeValid = true;
                })
                .catch((err) => {
                    MakeToast.create("Failed to access Code", "error");
                    this.qrCodeValid = false;
                    return;
                });
            console.log(this.qrCode.value);
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
        countDownTimer() {
            if (this.countDown > 0 && this.timer === true) {
                setTimeout(() => {
                    this.countDown -= 0.1;
                    this.countDownTimer();
                }, 100);
            }
        },
    },
    computed: {
        usersVirtualkeys: function () {
            return Array.from(this.virtualKeys).filter((virtualKey) => {
                return virtualKey.user_id === this.attrs.user.id;
            });
        },
        notUsersVirtualKeys: function () {
            return Array.from(this.virtualKeys).filter((virtualKey) => {
                return virtualKey.user_id !== this.attrs.user.id;
            });
        },
    },
    created() {
        this.isSafari();
        this.getVirtualKeys();
        this.getRole();
    },
};
</script>
