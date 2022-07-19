<script setup>
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
</script>

<template>
  <JetFormSection v-on:submit.prevent="submitForm">
    <template #title> Gate Details </template>

    <template #description> Create a new Gate by serial number </template>

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
        <JetLabel for="magic_code" value="Magic code" class="mt-5" />
        <JetInput
          id="magic_code"
          v-model="form.magicCode"
          type="text"
          class="block w-full mt-1"
          autofocus
        />
        <JetLabel for="name" value="Name" class="mt-5" />
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
        magic_code: "",
        name: "",
        team_id: 0,
      },
    };
  },
  methods: {
    validForm(serial_number, regex) {
      if (regex == "guid") {
        var guidRegex =
          /(\{){0,1}[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}(\}){0,1}/;
        return guidRegex.test(data);
      } else {
        var serialNumberRegex = /[A-Z0-9]{10}/;
        return serialNumberRegex.test(data);
      }
    },
    submitForm() {
      if (/[A-Z0-9]{10}/.test(this.form.serial_number, "serialNumber")) {
        const data = {
          serial_number: this.form.serial_number,
          magic_code: this.form.magic_code,
          name: this.form.name,
          team_id: this.attrs.user.current_team.id,
        };
        axios
          .post("/gates", data)
          .then((response) => (this.dataId = response.data.id));
        this.$inertia.get("../dashboard");
      } else {
        error;
      }
    },
  },
};
</script>
