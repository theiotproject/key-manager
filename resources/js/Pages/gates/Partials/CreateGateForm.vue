<script setup>
import JetButton from '@/Jetstream/Button.vue';
import JetFormSection from '@/Jetstream/FormSection.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetLabel from '@/Jetstream/Label.vue';

</script>

<template>

    <JetFormSection v-on:submit.prevent="submitForm">
        <template #title>
            Gate Details
        </template>

        <template #description>
            Create a new Gate by serial number
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

            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="serial_number" value="Serial number" />
                <JetInput
                    id="serial_number"
                    v-model="form.serial_number"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />
                <JetLabel for="name" value="Name" class="mt-5"/>
                <JetInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />
<!--                <JetInputError :message="form.errors.name" class="mt-2" />-->
            </div>
        </template>

        <template #actions>
            <JetButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Create
            </JetButton>
        </template>
    </JetFormSection>
</template>
<script>
export default {
    name: 'CreateGateForm',
    props: ['attrs'],
    data: function() {
        return {
            form: {
                serial_number: '',
                name: '',
                team_id: 0
            }
        }
    },
    methods: {
        submitForm() {
            const data = {serial_number: this.form.serial_number, name: this.form.name, team_id: this.attrs.user.current_team.id}
            axios.post("/api/gate", data)
                .then(response => this.dataId = response.data.id);
            this.$inertia.get('../dashboard');
        }
    }
}
</script>
