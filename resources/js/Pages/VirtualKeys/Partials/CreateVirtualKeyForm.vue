<script setup>
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetLabel from "@/Jetstream/Label.vue";
import SearchBar from "../../../Components/Form/Partials/SearchBar.vue";
</script>

<template>
    <JetFormSection v-on:submit.prevent="submitForm">
        <template #title> Virtual Key Details </template>

        <template #description>
            Create a new Virtual Key for users by selecting the Gates, and the
            time period
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
                    <ul
                        class="items-center w-full font-medium text-gray-900 bg-white rounded-lg sm:flex-wrap sm:flex"
                    >
                        <li
                            v-for="(day, index) in days"
                            :key="index"
                            class="w-auto sm:w-28 border rounded-lg m-0.5 border-gray-200 sm:border-r"
                        >
                            <div class="flex items-center pl-3">
                                <input
                                    v-model="form.checkedDays"
                                    v-bind:id="index"
                                    type="checkbox"
                                    :value="index"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 focus:ring-2"
                                />
                                <label
                                    v-bind:id="index"
                                    class="py-2 ml-2 w-full text-xs font-medium text-gray-900"
                                >
                                    {{ day }}
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
                <hr class="mt-5 mb-5" />

                <div>
                    <JetLabel for="gates" value="Gates" class="mb-3" />
                    <ul
                        class="overflow-y-auto px-3 pb-3 max-h-48 text-sm text-gray-700"
                        aria-labelledby="dropdownSearchButton"
                    >
                        <li v-for="(gate, index) in gates" :key="index">
                            <div
                                class="flex items-center p-2 rounded hover:bg-gray-100"
                            >
                                <input
                                    v-model="form.checkedGates"
                                    v-bind:id="index"
                                    type="checkbox"
                                    :value="gate"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 focus:ring-2 d"
                                />
                                <label
                                    for="{{index}}"
                                    class="ml-2 w-full text-sm font-medium text-gray-900 rounded"
                                    >{{ gate.name }}</label
                                >
                            </div>
                        </li>
                    </ul>
                </div>

                <hr class="mt-5 mb-5" />

                <div>
                    <JetLabel for="users" value="Users" />
                    <SearchBar />
                    <ul
                        class="overflow-y-auto px-3 pb-3 max-h-48 text-sm text-gray-700"
                        aria-labelledby="dropdownSearchButton"
                    >
                        <li v-for="(user, index) in users" :key="index">
                            <div
                                class="flex items-center p-2 rounded hover:bg-gray-100"
                            >
                                <input
                                    v-model="form.checkedUsers"
                                    v-bind:id="index"
                                    type="checkbox"
                                    :value="user"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 focus:ring-2"
                                />
                                <label
                                    for="{{index}}"
                                    class="ml-2 w-full text-sm font-medium text-gray-900 rounded"
                                    >{{ user.name }}</label
                                >
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </template>
        <template #actions>
            <JetButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Create
            </JetButton>
        </template>
    </JetFormSection>
</template>
<script>
export default {
    props: ["attrs"],
    name: "CreateVirtualKeyForm",
    data: function () {
        return {
            form: {
                label: "",
                checkedDays: [0, 1, 2, 3, 4],
                checkedUsers: [],
                checkedGates: [],
            },
            users: {},
            gates: {},
            days: [
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday",
                "Saturday",
                "Sunday",
            ],
            daysLetter: ["M", "T", "W", "R", "F", "S", "U"],
        };
    },
    methods: {
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
            axios.post("/virtualKeys", data).then();
            this.$inertia.get("../dashboard");
        },
        getUsers() {
            axios
                .get(`/auth/users/${this.attrs.user.current_team_id}`)
                .then((response) => {
                    this.users = response.data;
                });
        },
        getGates() {
            axios
                .get(
                    `/gates/teamId/${this.attrs.user.current_team_id}/resource`
                )
                .then((response) => {
                    this.gates = response.data.data;
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
