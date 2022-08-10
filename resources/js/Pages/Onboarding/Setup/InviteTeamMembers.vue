<script setup>
import { ref, onMounted } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetActionSection from "@/Jetstream/ActionSection.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetConfirmationModal from "@/Jetstream/ConfirmationModal.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import FormSection from "../../../Components/Form/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetSectionBorder from "@/Jetstream/SectionBorder.vue";

const props = defineProps(["team"]);

const invitations = ref(Array);

const addTeamMemberForm = useForm({
  email: "",
  role: null,
});

const addTeamMember = () => {
  addTeamMemberForm.post(route("team-members.store", props.team), {
    errorBag: "addTeamMember",
    preserveScroll: true,
    onSuccess: () => getTeamInvitations(),
  });
};

const getTeamInvitations = () => {
  axios.get(`/api/teams/data/${props.team.id}`).then((response) => {
    invitations.value = response.data;
  });addTeamMemberForm.reset()
};

const cancelTeamInvitation = (invitation) => {
  Inertia.delete(route("team-invitations.destroy", invitation), {
    preserveScroll: true,
  });
  getTeamInvitations();
};

const displayableRole = (role) => {
  return props.availableRoles.find((r) => r.key === role).name;
};
</script>

<template>
  <div class="w-200">
    <!-- Add Team Member -->
    <FormSection
      @submitted="
        addTeamMember();
        getInvitationsLength();
      "
    >
      <template #form>
        <div class="col-span-6">
          <div class="text-sm text-gray-600">
            <p class="pb-3">Step 2 of 3</p>
            <h1 class="text-4xl">Who else is on the {{ team.name }}?</h1>
            <p class="pt-3">
              Please provide the email address of the person you would like to
              add to this team.
            </p>
          </div>
        </div>

        <!-- Member Email -->
        <div class="col-span-6 sm:col-span-4">
          <JetLabel for="email" value="Email" />
          <div class="flex items-center">
            <JetInput
              id="email"
              v-model="addTeamMemberForm.email"
              type="email"
              class="mt-1 block w-full"
            />
            <JetButton
              class="h-10 mt-1 ml-1"
              :class="{ 'opacity-25': addTeamMemberForm.processing }"
              :disabled="addTeamMemberForm.processing"
            >
              Add
            </JetButton>
          </div>
          <JetInputError
            :message="addTeamMemberForm.errors.email"
            class="mt-2"
          />
        </div>

        <!-- Role -->
        <div v-if="availableRoles.length > 0" class="col-span-6 lg:col-span-4">
          <JetLabel for="roles" value="Role" />
          <JetInputError
            :message="addTeamMemberForm.errors.role"
            class="mt-2"
          />

          <div
            class="
              relative
              z-0
              mt-1
              border border-gray-200
              rounded-lg
              cursor-pointer
            "
          >
            <button
              v-for="(role, i) in availableRoles"
              :key="role.key"
              type="button"
              class="
                relative
                px-4
                py-3
                inline-flex
                w-full
                rounded-lg
                focus:z-10
                focus:outline-none
                focus:border-blue-300
                focus:ring
                focus:ring-blue-200
              "
              :class="{
                'border-t border-gray-200 rounded-t-none': i > 0,
                'rounded-b-none': i != Object.keys(availableRoles).length - 1,
              }"
              @click="addTeamMemberForm.role = role.key"
            >
              <div
                :class="{
                  'opacity-50':
                    addTeamMemberForm.role &&
                    addTeamMemberForm.role != role.key,
                }"
              >
                <!-- Role Name -->
                <div class="flex items-center">
                  <div
                    class="text-sm text-gray-600"
                    :class="{
                      'font-semibold': addTeamMemberForm.role == role.key,
                    }"
                  >
                    {{ role.name }}
                  </div>

                  <svg
                    v-if="addTeamMemberForm.role == role.key"
                    class="ml-2 h-5 w-5 text-green-400"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>

                <!-- Role Description -->
                <div class="mt-2 text-xs text-gray-600 text-left">
                  {{ role.description }}
                </div>
              </div>
            </button>
          </div>
        </div>
      </template>

      <template #actions>
        <JetActionMessage
          :on="addTeamMemberForm.recentlySuccessful"
          class="mr-3"
        >
          Added.
        </JetActionMessage>
        <div
          class="
            inline-flex
            items-center
            px-4
            py-2
            bg-gray-800
            border border-transparent
            rounded-md
            font-semibold
            text-xs text-white
            uppercase
            tracking-widest
            hover:bg-gray-700
            active:bg-gray-900
            focus:outline-none
            focus:border-gray-900
            focus:ring
            focus:ring-gray-300
            disabled:opacity-25
            transition
            cursor-pointer
          "
          :disabled="addTeamMemberForm.processing"
          @click="nextStep"
        >
          {{ invitationsLength > 0 ? "NEXT" : "SKIP" }}
        </div>
      </template>
    </FormSection>

    <div v-if="invitationsLength > 0">
      <JetSectionBorder />

      <!-- Team Member Invitations -->
      <JetActionSection class="mt-10 sm:mt-0">
        <template #title> Pending Team Invitations </template>

        <template #description>
          These people have been invited to your team and have been sent an
          invitation email. They may join the team by accepting the email
          invitation.
        </template>

        <!-- Pending Team Member Invitation List -->
        <template #content>
          <div class="space-y-6">
            <div
              v-for="invitation in invitations"
              :key="invitation.id"
              class="flex items-center justify-between"
            >
              <div class="text-gray-600">
                {{ invitation.email }}
              </div>

              <div class="flex items-center">
                <!-- Cancel Team Invitation -->
                <button
                  class="
                    cursor-pointer
                    ml-6
                    text-sm text-red-500
                    focus:outline-none
                  "
                  @click="
                    cancelTeamInvitation(invitation);
                    getInvitationsLength();
                  "
                >
                  Cancel
                </button>
              </div>
            </div>
          </div>
        </template>
      </JetActionSection>
    </div>
  </div>
</template>
<script>
export default {
  props: ["attrs", "team"],
  data() {
    return {
      availableRoles: Object,
      invitationsLength: 0,
    };
  },
  methods: {
    nextStep() {
      this.$inertia.get(this.route("dashboard"));
    },
    getRoles() {
      axios.get(`/api/teams/roles`).then((response) => {
        this.availableRoles = response.data;
      });
    },
    getInvitationsLength() {
      axios.get(`/api/teams/data/${this.team.id}`).then((response) => {
        this.invitationsLength = response.data.length;
      });
      return this.invitationsLength;
    },
  },
  created() {
    this.getRoles();
  },
};
</script>
