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
            MakeToast.create("Deleted Gate successfully", "success");
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
                                    ><thead class="text-xs text-white uppercase bg-gradient-to-r from-blue-500 to-sky-400" v-if="!isSafari()">
                                  <tr>
                                      <th scope="col" class="px-6 py-3 rounded-l-lg">Name</th>
                                      <th scope="col" class="px-6 py-3 text-right rounded-r-lg"></th>
                                  </tr>
                                  </thead>
                                  <thead class="text-xs text-white uppercase bg-blue-500" v-if="isSafari()">
                                            <tr>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3 rounded-l-lg"
                                                >
                                                    Name
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3 text-right rounded-r-lg"
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
                                                    class="lg:px-6 md:px-3 py-4 font-medium text-gray-900 whitespace-nowrap"
                                                >
                                                    {{ gate.name }}
                                                </td>
                                                <td
                                                    class="lg:px-6 md:px-3 py-4 font-medium text-right text-gray-900 whitespace-nowrap"
                                                >
                                                    <button
                                                        class="cursor-pointer ml-6 text-sm text-red-500"
                                                        @click="
                                                            confirmGateRemoval(
                                                                gate
                                                            )
                                                        "
                                                    >
                                                        Remove
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
                :show="gateBeingRemoved"
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
            attrs: this.$attrs,
        };
    },
    methods: {
        getGates() {
            axios
                .get(
                    `/gates/teamId/${this.attrs.user.current_team_id}/resource`
                )
                .then((response) => {
                    this.gates = response.data.data;
                })
                .catch((err) => {
                    MakeToast.create("Cannot load gates", "error");
                });
        },
        getPermission() {
            axios
                .get(
                    `/auth/permission/teamId/${this.attrs.user.current_team_id}`
                )
                .then((response) => {
                    this.permission = response.data;
                })
                .catch((err) => {
                    MakeToast.create("Cannot load permission", "error");
        });
    },
      isSafari(){
          return /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
      }
  },
  created() {
      this.isSafari();
        this.getGates();
        this.getPermission();
    },
};
</script>
