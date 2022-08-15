<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import JetConfirmationModal from "@/Jetstream/ConfirmationModal.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
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
                                                    class="lg:px-3 md:px-0 sm:rounded-r-lg border-none rounded-none"
                                                ></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                class="bg-white border-b"
                                                v-for="virtualKey in virtualKeys"
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
        </div>
    </AppLayout>
</template>

<script>
export default {
    name: "VirtualKeyShow",
    data() {
        return {
            editHover: false,
            virtualKeys: {},
            role: "",
            attrs: this.$attrs,
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
    },
    created() {
        this.isSafari();
        this.getVirtualKeys();
        this.getRole();
    },
};
</script>
