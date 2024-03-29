<script setup>
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import MakeToast from "../../../Services/MakeToast.vue";
</script>

<template>
    <JetFormSection v-on:submit.prevent="submitForm">
        <template #title> Gate Details </template>

        <template #description> Create a new Gate by complete this form
            <br><br>
            <b>Serial Number</b> is a unique number that each gate has
            <br><br>
            Automatically generated <b>Magic Code</b> is used as a backup opening code for the administrator
            <br><br>
            You can copy it and keep it in a safe place
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

            <div class="col-span-6 sm:col-span-4" v-for="index in quantity">
                <hr class="mt-5 mb-5" v-if="index > 1"/>
                <p v-if="index>1">{{index}}</p>
                <JetLabel for="name" value="Name" />
                <JetInput
                    id="name"
                    v-model="form.name[index -1]"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />

                <JetLabel
                    for="serial_number"
                    value="Serial number"
                    class="mt-5"
                />
                <div class="flex items-center">
                <JetInput
                    :id="`serial_number${index-1}`"
                    v-model="form.serial_number[index - 1]"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />
                <div class="flex flex-col items-center m-5">
                    <div v-if="hint[index - 1]" class="absolute px-5 border-2 bg-black opacity-60 rounded-2xl text-white p-3 -mt-16 ">Serial number consists of 10 characters (numbers and capital letters) </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 relative cursor-help" viewBox="0 0 20 20" fill="#374151" @mouseover="hint[index - 1] = true" @mouseout="hint[index - 1] = false">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                    </svg>
                </div>
                </div>
                <JetLabel
                    for="magic_code"
                    value="Magic Code (GUID)"
                    class="mt-5"
                />
                <div class="flex items-center">
                    <JetInput
                        id="magic_code"
                        v-model="form.magic_code[index - 1]"
                        :type="form.passwordFieldType[index - 1]"
                        class="block w-full mt-1"
                        autofocus
                    />
                    <div @click="switchVisibility(index - 1)" class="m-5 cursor-pointer">
                        <svg
                            v-if="form.passwordFieldType[index - 1] == 'password'"
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            viewBox="0 0 20 20"
                            fill="#374151"
                        >
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path
                                fill-rule="evenodd"
                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        <svg
                            v-if="form.passwordFieldType[index - 1] != 'password'"
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            viewBox="0 0 20 20"
                            fill="#374151"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"
                                clip-rule="evenodd"
                            />
                            <path
                                d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"
                            />
                        </svg>
                    </div>
                </div>
                <JetInputError :message="form.errors.name" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <div class="flex justify-between w-full">
            <div
                @click="nextGate"
                class="
          mr-10
          cursor-pointer
          hover:text-black
          text-gray-600
          flex
          items-center
          gap-2
        "
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
                Add next gate
            </div>
            <JetButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Create
            </JetButton>
            </div>
        </template>
    </JetFormSection>
</template>
<script>
export default {
    name: "CreateGateForm",
    props: ["attrs", "createVirtualKey"],
    data: function () {
        return {
            quantity: 1,
            createVirtualKey: this.createVirtualKey,
            hint: [false],
            form: {
                passwordFieldType: ["password"],
                serial_number: [""],
                magic_code: [this.generateGuid()],
                name: [""],
                errors: {
                    name: "",
                },
                team_id: 0,
            },
        };
    },
    methods: {
        // sernum(index) {
        //     var tele = document.querySelector('#serial_number' + index);
        //     tele.addEventListener('keydown', function(e) {
        //         if (event.key != 'Backspace' && (tele.value.length === 4 || tele.value.length === 8)) {
        //             tele.value += '-';
        //         }
        //     });
        // },
        // validForm(serial_number, magic_code) {
        //     var serialNumberRegex = /[A-Z0-9]{4}-[A-Z0-9]{3}-[A-Z0-9]{3}/;
        //     var guidRegex =
        //         /^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i;
        //     if (!serialNumberRegex.test(serial_number.toUpperCase())) {
        //         this.form.errors.name = "Serial Number is not valid";
        //         return false;
        //     }
        //     if (!guidRegex.test(magic_code)) {
        //         this.form.errors.name = "Magic Code is not valid";
        //         return false;
        //     }
        //     return true;
        // },
        generateGuid() {
            return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, (c) =>
                (
                    c ^
                    (crypto.getRandomValues(new Uint8Array(1))[0] &
                        (15 >> (c / 4)))
                ).toString(16)
            );
        },
        submitForm() {
            let gates = [];
            for(let i = 0; i < this.quantity; i++) {
                // if (this.validForm(this.form.serial_number[i], this.form.magic_code[i])) {
                    let newGate = {
                        serial_number: this.form.serial_number[i],
                        magic_code: this.form.magic_code[i],
                        name: this.form.name[i],
                        team_id: this.attrs.user.current_team.id,
                    };
                    gates.push(newGate);
                // } else {
                //     return;
                // }
            }
                const data = {
                    gates: gates,
                };
                axios
                    .post("/gates", data)
                    .then((response) => {
                        if(this.createVirtualKey === true){
                            this.$inertia.get('../../virtualKeys/create');
                        } else {
                            this.$inertia.get("../../dashboard");
                        }
                        this.dataId = response.data.id;
                        MakeToast.create("Gate successfully added", "info");
                    })
                    .catch((err) => {
                        MakeToast.create("Cannot create Gate", "error");
                    });
        },
        switchVisibility(index) {
            this.form.passwordFieldType[index] =
                this.form.passwordFieldType[index] === "password"
                    ? "text"
                    : "password";
        },
        nextGate(){
            this.form.magic_code[this.quantity] = this.generateGuid();
            this.form.passwordFieldType[this.quantity] = "password";
            this.quantity++;
        }
    },
};
</script>
