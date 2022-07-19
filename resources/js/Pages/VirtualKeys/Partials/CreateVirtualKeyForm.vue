<script setup>
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetLabel from "@/Jetstream/Label.vue";
import CheckboxList from "../../../Components/Form/CheckboxList.vue";
import GatesList from "../../../Components/Form/GatesList.vue";
import UsersList from "../../../Components/Form/UsersList.vue";
import DialogModal from "../../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/DialogModal.vue";
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
                    <CheckboxList />
                </div>
                <hr class="mt-5 mb-5" />

                <div>
                    <UsersList />
                </div>
                <hr class="mt-5 mb-5" />

                <div>
                    <GatesList />
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
    name: "CreateGateForm",
    props: ["attrs"],
    data: function () {
        return {
            form: {
                serial_number: "",
                name: "",
                team_id: 0,
                // selection: {
                //     day_from: "0",
                //     day_to: "4",
                // },
                // picker: {
                //     time_from: {
                //         HH: "07",
                //         mm: "30",
                //     },
                //     time_to: {
                //         HH: "16",
                //         mm: "00",
                //     },
                // },
            },
        };
    },
    methods: {
        submitForm() {
            const data = {
                serial_number: this.form.serial_number,
                name: this.form.name,
                team_id: this.attrs.user.current_team.id,
            };
            axios
                .post("/api/gate", data)
                .then((response) => (this.dataId = response.data.id));
            this.$inertia.get("../dashboard");
        },
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
