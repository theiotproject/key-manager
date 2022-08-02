<script setup>
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetLabel from "@/Jetstream/Label.vue";
import SearchBar from "../../../Components/Form/Partials/SearchBar.vue";
import JetInput from "@/Jetstream/Input.vue";

import MakeToast from "../../../Services/MakeToast.vue";
</script>

<template>
    <JetFormSection v-on:submit.prevent="submitForm">
        <template #title> Virtual Ticket Details </template>

        <template #description>
            Create a new Virtual Ticket for users by selecting the Gates, and
            the time period. It will be send via email to the selected Users
        </template>

        <template #form>
            <div class="col-span-6">
                <JetLabel value="Team" />

                <div class="flex items-center mt-2">
                    <div class="leading-tight">
                        <div>{{ $page.props.user.current_team.name }}</div>
                    </div>
                </div>
            </div>
            <div class="col-span-6 sm:col-span-full">
                <div>
                    <JetLabel value="Days" class="mb-3" />
                    <v-date-picker v-model="form.date" is-range />
                </div>
                <hr class="mt-5 mb-5" />

                <div>
                    <JetLabel for="gates" value="Gates" class="mb-3" />
                    <ul
                        class="overflow-y-auto pl-0 px-3 pb-3 max-h-48 text-sm text-gray-700"
                        aria-labelledby="dropdownSearchButton"
                    >
                        <li
                            v-for="(gate, index) in gates"
                            :key="index"
                            @click="checkGate(index)"
                        >
                            <div
                                class="flex items-center p-2 rounded hover:bg-gray-100 cursor-pointer"
                            >
                                <input
                                    v-model="form.checkedGates"
                                    v-bind:id="index"
                                    type="checkbox"
                                    :value="gate"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 focus:ring-2 cursor-pointer"
                                />
                                <label
                                    for="{{index}}"
                                    class="ml-2 w-full text-sm font-medium text-gray-900 rounded cursor-pointer"
                                    >{{ gate.name }}</label
                                >
                            </div>
                        </li>
                    </ul>
                </div>

                <hr class="mt-5 mb-5" />

                <div>
                    <JetLabel for="users" value="Users" />
                    <!-- <SearchBar /> -->
                    <ul
                        class="overflow-y-auto pl-0 px-3 pb-3 max-h-48 text-sm text-gray-700"
                        aria-labelledby="dropdownSearchButton"
                    >
                        <li
                            v-for="(user, index) in users"
                            :key="index"
                            @click="checkUser(index)"
                            class="cursor-pointer"
                        >
                            <div
                                class="flex items-center p-2 rounded hover:bg-gray-100 cursor-pointer"
                            >
                                <input
                                    v-model="form.checkedUsers"
                                    v-bind:id="index"
                                    type="checkbox"
                                    :value="user"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 focus:ring-2 cursor-pointer"
                                />
                                <div>
                                    <label
                                        for="{{index}}"
                                        class="ml-2 w-full text-sm font-medium text-gray-900 rounded cursor-pointer"
                                        >{{ user.name }}</label
                                    >
                                    <label
                                        for="{{index}}"
                                        class="ml-5 w-full text-sm font-medium text-gray-600 rounded cursor-pointer"
                                        >{{ user.email }}</label
                                    >
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <hr class="mt-5 mb-5" />

                <div>
                    <label
                        for="email"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                        >Your Email</label
                    >
                    <div class="relative mb-6">
                        <div
                            class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none"
                        >
                            <svg
                                aria-hidden="true"
                                class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"
                                ></path>
                                <path
                                    d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"
                                ></path>
                            </svg>
                        </div>
                        <input
                            v-model="form.email"
                            type="email"
                            id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="johndove@gmail.com"
                        />
                    </div>
                </div>
            </div>
        </template>
        <template #actions>
            <JetButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Send email
            </JetButton>
        </template>
    </JetFormSection>
</template>
<script>
export default {
    props: ["attrs"],
    name: "CreateVirtualTicketForm",

    data: function () {
        return {
            form: {
                date: "",
                label: "",
                email: "",
                checkedUsers: [],
                checkedGates: [],
            },
            users: {},
            gates: {},
            checkedEmails: [],
        };
    },
    methods: {
        checkUser(index) {
            let canCheck = true;
            this.form.checkedUsers.find((checkedUser, id) => {
                if (checkedUser == this.users[index]) {
                    this.form.checkedUsers.splice(id, 1);
                    canCheck = false;
                    return;
                }
            });
            if (canCheck) {
                this.form.checkedUsers.push(this.users[index]);
            }
        },
        checkGate(index) {
            let canCheck = true;
            this.form.checkedGates.find((checkedGate, id) => {
                if (checkedGate == this.gates[index]) {
                    this.form.checkedGates.splice(id, 1);
                    canCheck = false;
                    return;
                }
            });
            if (canCheck) {
                this.form.checkedGates.push(this.gates[index]);
            }
        },
        submitForm() {
            let str = "";
            this.form.checkedDays.forEach((day) => {
                str += this.daysLetter[day];
            });

            let users = [];
            let gates = [];

            this.form.checkedUsers.forEach((user) => {
                let label = "Key opens ";

                this.form.checkedGates.forEach((gate, index) => {
                    gates.push(gate.id);
                    if (this.form.checkedGates.length - 1 == index) {
                        label += gate.name;
                    } else {
                        label += gate.name + ", ";
                    }
                });

                let newUser = {
                    id: user.id,
                    label: label,
                };
                users.push(newUser);
            });

            const data = {
                users: users,
                gates: gates,
                validDays: str,
            };
            axios
                .post("/virtualTickets", data)
                .then((result) => {
                    MakeToast.create("Added Virtual Ticket", "info");
                    this.$inertia.get("../dashboard");
                })
                .catch((err) => {
                    MakeToast.create("Failed to add Virtual Ticket", "error");
                });
        },
        getUsers() {
            axios
                .get(`/auth/users/${this.attrs.user.current_team_id}`)
                .then((response) => {
                    this.users = response.data;
                })
                .catch((err) => {
                    MakeToast.create("Cannot load users", "error");
                });
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
                    MakeToast.create("Cannot load gates", "error");
                });
        },
    },
    created() {
        this.getUsers();
        this.getGates();
    },
};
</script>
<style>
.select {
    position: relative;
}
select {
    padding: 8px 12px;
    border: 1px solid #cfd9db;
    background-color: #ffffff;
    border-radius: 0.25em;
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.08);

    display: block;
    width: 100%;
    appearance: none;
    cursor: pointer;
}
.select::after {
    content: "";
    position: absolute;
    z-index: 1;
    right: 16px;
    top: 50%;
    margin-top: -8px;
    display: block;
    width: 16px;
    height: 16px;
    background: url("data:image/svg+xml;charset=utf-8,%3C%3Fxml%20version%3D%221.0%22%20encoding%3D%22utf-8%22%3F%3E%0D%0A%3C%21DOCTYPE%20svg%20PUBLIC%20%22-%2F%2FW3C%2F%2FDTD%20SVG%201.1%2F%2FEN%22%20%22http%3A%2F%2Fwww.w3.org%2FGraphics%2FSVG%2F1.1%2FDTD%2Fsvg11.dtd%22%3E%0D%0A%3Csvg%20version%3D%221.1%22%20id%3D%22Layer_1%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%20x%3D%220px%22%20y%3D%220px%22%0D%0A%09%20width%3D%2216px%22%20height%3D%2216px%22%20viewBox%3D%220%200%2016%2016%22%20enable-background%3D%22new%200%200%2016%2016%22%20xml%3Aspace%3D%22preserve%22%3E%0D%0A%3Cg%3E%0D%0A%09%3Cpolygon%20fill%3D%22%232c3e50%22%20points%3D%220.9%2C5.5%203.1%2C3.4%208%2C8.3%2012.9%2C3.4%2015.1%2C5.5%208%2C12.6%20%09%22%2F%3E%0D%0A%3C%2Fg%3E%0D%0A%3C%2Fsvg%3E")
        no-repeat center center;
    pointer-events: none;
}
select::-ms-expand {
    display: none;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    cursor: pointer;
}
</style>
