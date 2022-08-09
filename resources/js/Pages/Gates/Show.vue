<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import JetConfirmationModal from "@/Jetstream/ConfirmationModal.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import MakeToast from "../../Services/MakeToast.vue";

const removeGateForm = useForm();

const gateBeingRemoved = ref(null);

const confirmGateRemoval = (gate) => {
    gateBeingRemoved.value = gate;
};

const removeGate = () => {
    removeGateForm.delete(route("gates.destroy", [gateBeingRemoved.value]), {
        errorBag: "removeGate",
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            gateBeingRemoved.value = null;
            MakeToast.create("Deleted Gate successfully", "info");
        },
        onError: () => {
            MakeToast.create("Cannot delete Gate", "error");
        },
    });
};
</script>
<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gates
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
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <p class="ml-3">Gates</p>
                        </h2>
                        <Link
                            v-if="role === 'owner' || role === 'admin'"
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
                            Create New Gate
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
                                                    Name
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3 text-right sm:rounded-r-lg rounded-none"
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
                                                    Name
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3 text-right sm:rounded-r-lg rounded-none"
                                                ></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                class="border-b"
                                                v-for="gate in gates"
                                                :key="gate.id"
                                            >
                                                <td
                                                    class="lg:px-6 md:px-3 px-5 py-4 font-medium text-gray-900 whitespace-nowrap"
                                                >
                                                    {{ gate.name }}
                                                </td>
                                                <td
                                                    class="lg:px-6 md:px-3 py-4 font-medium text-right text-gray-900 whitespace-nowrap flex items-center justify-end"
                                                >
                                                    <Link
                                                        v-if="
                                                            role === 'owner' ||
                                                            role === 'admin'
                                                        "
                                                        class="cursor-pointer ml-6 text-sm text-blue-500 hover:text-blue-700"
                                                        :href="
                                                            route(
                                                                'gates.edit',
                                                                [gate]
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
                                                            confirmGateRemoval(
                                                                gate
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
            <!-- Remove Gate Confirmation Modal -->
            <JetConfirmationModal
                :show="gateBeingRemoved !== null"
                @close="gateBeingRemoved = null"
            >
                <template #title> Remove Gate </template>

                <template #content>
                    Are you sure you would like to remove this gate?
                </template>

                <template #footer>
                    <JetSecondaryButton @click="gateBeingRemoved = null">
                        Cancel
                    </JetSecondaryButton>

                    <JetDangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': removeGateForm.processing }"
                        :disabled="removeGateForm.processing"
                        @click="removeGate"
                    >
                        Remove
                    </JetDangerButton>
                </template>
            </JetConfirmationModal>
        </div>
    </AppLayout>
</template>
<script>
export default {
    name: "GateShow",
    data() {
        return {
            gates: {},
            permission: 0,
            role: "",
            attrs: this.$attrs,
        };
    },
    methods: {
        showEditForm(gate) {
            console.log(gate.id);
            axios.get(`/gates/${gate.id}/edit`);
        },
        getGates() {
            axios
                .get(
                    `/gates/teamId/${this.attrs.user.current_team_id}/resource`
                )
                .then((response) => {
                    this.gates = response.data.data;
                })
                .catch((err) => {
                    // MakeToast.create("Cannot load gates", "error");
                });
        },
        getRole() {
            axios
                .get(`/auth/role/teamId/${this.attrs.user.current_team_id}`)
                .then((response) => {
                    this.role = response.data;
                })
                .catch((err) => {
                    MakeToast.create("Cannot load role", "error");
                });
        },
        isSafari() {
            return /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
        },
    },
    created() {
        this.isSafari();
        this.getGates();
        this.getRole();
    },
};
</script>
