<script setup>
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetActionSection from "@/Jetstream/ActionSection.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetConfirmationModal from "@/Jetstream/ConfirmationModal.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetSectionBorder from "@/Jetstream/SectionBorder.vue";
import MakeToast from "../../../Services/MakeToast.vue";

const props = defineProps({
  team: Object,
  availableRoles: Array,
  userPermissions: Object,
});

const addTeamMemberForm = useForm({
  email: "",
  role: null,
    gates: {},
    checkedGates: [],
    showAllGates: false,
    checkedDays: [0, 1, 2, 3, 4],
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
});

const updateRoleForm = useForm({
  role: null,
});

const leaveTeamForm = useForm();
const removeTeamMemberForm = useForm();

const currentlyManagingRole = ref(false);
const managingRoleFor = ref(null);
const confirmingLeavingTeam = ref(false);
const teamMemberBeingRemoved = ref(null);

const getGates = () => {
    axios.get(`/gates/teamId/${props.team.id}/resource`).then((response) => {
        addTeamMemberForm.gates = response.data.data;
    })
}

getGates();

const checkGate = (index) => {
    let canCheck = true;
    addTeamMemberForm.checkedGates.find((checkedGate, id) => {
        if (checkedGate === addTeamMemberForm.gates[index]) {
            addTeamMemberForm.checkedGates.splice(id, 1);
            canCheck = false;
            return;
        }
    });

    if (canCheck) {
        addTeamMemberForm.checkedGates.push(addTeamMemberForm.gates[index]);
    }
};

const checkDay= (index) => {
    let canCheck = true;
    addTeamMemberForm.checkedDays.find((checkedDay, id) => {
        if (checkedDay === index) {
            addTeamMemberForm.checkedDays.splice(id, 1);
            canCheck = false;
            return;
        }
    });
    if (canCheck) {
        addTeamMemberForm.checkedDays.push(index);
    }
};

const addTeamMember = () => {
  addTeamMemberForm.post(route("team-members.store", props.team), {
    errorBag: "addTeamMember",
    preserveScroll: true,
  });
  if(addTeamMemberForm.checkedGates.length > 0){
      addFutureVirtualKey();
  }
};

const addFutureVirtualKey = () => {
    if (addTeamMemberForm.checkedDays <= 0 && addTeamMemberForm.checkedGates > 0) {
        MakeToast.create("Choose at least 1 Day", "warning");
        return;
    }
    if (addTeamMemberForm.checkedGates <= 0) {
        MakeToast.create("Choose at least 1 Gate", "warning");
        return;
    }

    let str = "";
    addTeamMemberForm.checkedDays.forEach((day) => {
        str += addTeamMemberForm.daysLetter[day];
    });

    let gates = [];

    let label = "Key opens ";
    addTeamMemberForm.checkedGates.forEach((gate, index) => {
        gates.push(gate.id);
        if (addTeamMemberForm.checkedGates.length - 1 === index) {
            label += gate.name;
        } else {
            label += gate.name + ", ";
        }
    });

    const data = {
        label: label,
        email: addTeamMemberForm.email,
        gates: gates,
        validDays: str,
    };
    axios
        .post("/api/futureVirtualKeys", data)
        .then((result) => {
            MakeToast.create("Added Future Virtual Key", "info");
            const gates = addTeamMemberForm.gates;
            addTeamMemberForm.reset();
            addTeamMemberForm.gates = gates;
        })
        .catch((err) => {
            MakeToast.create("Failed to add Virtual Key", "error");
        });
};

const cancelTeamInvitation = (invitation) => {
  Inertia.delete(route("team-invitations.destroy", invitation), {
    preserveScroll: true,
  });
};

const manageRole = (teamMember) => {
  managingRoleFor.value = teamMember;
  updateRoleForm.role = teamMember.membership.role;
  currentlyManagingRole.value = true;
};

const updateRole = () => {
  updateRoleForm.put(
    route("team-members.update", [props.team, managingRoleFor.value]),
    {
      preserveScroll: true,
      onSuccess: () => (currentlyManagingRole.value = false),
    }
  );
};

const confirmLeavingTeam = () => {
  confirmingLeavingTeam.value = true;
};

const leaveTeam = () => {
  leaveTeamForm.delete(
    route("team-members.destroy", [props.team, usePage().props.value.user])
  );
};

const confirmTeamMemberRemoval = (teamMember) => {
  teamMemberBeingRemoved.value = teamMember;
};

const removeTeamMember = () => {
  removeTeamMemberForm.delete(
    route("team-members.destroy", [props.team, teamMemberBeingRemoved.value]),
    {
      errorBag: "removeTeamMember",
      preserveScroll: true,
      preserveState: true,
      onSuccess: () => (teamMemberBeingRemoved.value = null),
    }
  );
};

const displayableRole = (role) => {
  return props.availableRoles.find((r) => r.key === role).name;
};
</script>

<template>
  <div>
    <div v-if="userPermissions.canAddTeamMembers">
      <JetSectionBorder />

      <!-- Add Team Member -->
      <JetFormSection @submitted="addTeamMember">
        <template #title> Add Team Member </template>

        <template #description>
          Add a new team member to your team, allowing them to collaborate with
          you.
        </template>

        <template #form>
          <div class="col-span-6">
            <div class="max-w-xl text-sm text-gray-600">
              Please provide the email address of the person you would like to
              add to this team.
            </div>
          </div>

          <!-- Member Email -->
          <div class="col-span-6 sm:col-span-4">
            <JetLabel for="email" value="Email" />
            <JetInput
              id="email"
              v-model="addTeamMemberForm.email"
              type="email"
              class="mt-1 block w-full"
            />
            <JetInputError
              :message="addTeamMemberForm.errors.email"
              class="mt-2"
            />
          </div>

          <!-- Role -->
          <div
            v-if="availableRoles.length > 0"
            class="col-span-6 lg:col-span-4"
          >
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
            <!-- Future Virtual Key -->
            <div
                v-if="addTeamMemberForm.role === 'user'"
                class="col-span-6 lg:col-span-4"
            >
                <JetLabel for="futureVirtualKeys" value="You can give access to gates by creating future virtual key for new user" />
                <JetInputError
                    :message="addTeamMemberForm.errors.role"
                    class="mt-2"
                />

                <ul
                    class="overflow-y-auto pl-0 px-3 pb-3 max-h-48 text-sm text-gray-700"
                    aria-labelledby="dropdownSearchButton"
                >
                    <li
                        v-for="(gate, index) in addTeamMemberForm.gates"
                        :key="index"
                        class="cursor-pointer"
                    >
                        <div
                            v-if="index < 3 || addTeamMemberForm.showAllGates"
                            class="flex items-center p-2 rounded hover:bg-gray-100 cursor-pointer"
                            @click="checkGate(index)"
                        >
                            <input
                                v-model="addTeamMemberForm.checkedGates"
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
                    <p class="cursor-pointer" @click="addTeamMemberForm.showAllGates = !addTeamMemberForm.showAllGates">{{addTeamMemberForm.showAllGates ? 'Show less gates' : `Show ${addTeamMemberForm.gates.length - 3} more gates`}}</p>
                </ul>
                <div v-if="addTeamMemberForm.checkedGates.length > 0">
                    <hr class="mt-5 mb-5" />
                    <JetLabel value="On which days of the week should the user have access to the selected gates?" class="mb-3" />
                    <ul
                        class="items-center w-full font-medium text-gray-900 bg-white rounded-lg sm:flex-wrap sm:flex"
                    >
                        <li
                            v-for="(day, index) in addTeamMemberForm.days"
                            :key="index"
                            class="w-auto sm:w-28 border rounded-lg m-0.5 border-gray-200 sm:border-r cursor-pointer hover:bg-gray-100"
                        >
                            <div
                                @click="checkDay(index)"
                                class="flex items-center pl-3 cursor-pointer"
                            >
                                <input
                                    v-model="addTeamMemberForm.checkedDays"
                                    v-bind:id="index"
                                    type="checkbox"
                                    :value="index"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 focus:ring-2 cursor-pointer"
                                />
                                <label
                                    v-bind:id="index"
                                    class="py-2 ml-2 w-full text-xs font-medium text-gray-900 cursor-pointer"
                                >
                                    {{ day }}
                                </label>
                            </div>
                        </li>
                    </ul>
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

          <JetButton
            :class="{ 'opacity-25': addTeamMemberForm.processing }"
            :disabled="addTeamMemberForm.processing"
          >
            Add
          </JetButton>
        </template>
      </JetFormSection>
    </div>

    <div
      v-if="
        team.team_invitations.length > 0 && userPermissions.canAddTeamMembers
      "
    >
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
              v-for="invitation in team.team_invitations"
              :key="invitation.id"
              class="flex items-center justify-between"
            >
              <div class="text-gray-600">
                {{ invitation.email }}
              </div>

              <div class="flex items-center">
                <!-- Cancel Team Invitation -->
                <button
                  v-if="userPermissions.canRemoveTeamMembers"
                  class="
                    cursor-pointer
                    ml-6
                    text-sm text-red-500
                    focus:outline-none
                  "
                  @click="cancelTeamInvitation(invitation)"
                >
                  Cancel
                </button>
              </div>
            </div>
          </div>
        </template>
      </JetActionSection>
    </div>

    <div v-if="team.users.length > 0">
      <JetSectionBorder />

      <!-- Manage Team Members -->
      <JetActionSection class="mt-10 sm:mt-0">
        <template #title> Team Members </template>

        <template #description>
          All of the people that are part of this team.
        </template>

        <!-- Team Member List -->
        <template #content>
          <div class="space-y-6">
            <div
              v-for="user in team.users"
              :key="user.id"
              class="flex items-center justify-between"
            >
              <div class="flex items-center">
                <img
                  class="w-8 h-8 rounded-full"
                  :src="user.profile_photo_url"
                  :alt="user.name"
                />
                <div class="ml-4">
                  {{ user.name }}
                </div>
              </div>

              <div class="flex items-center">
                <!-- Manage Team Member Role -->
                <button
                  v-if="
                    userPermissions.canAddTeamMembers && availableRoles.length
                  "
                  class="ml-2 text-sm text-gray-400 underline"
                  @click="manageRole(user)"
                >
                  {{ displayableRole(user.membership.role) }}
                </button>

                <div
                  v-else-if="availableRoles.length"
                  class="ml-2 text-sm text-gray-400"
                >
                  {{ displayableRole(user.membership.role) }}
                </div>

                <!-- Leave Team -->
                <button
                  v-if="$page.props.user.id === user.id"
                  class="cursor-pointer ml-6 text-sm text-red-500"
                  @click="confirmLeavingTeam"
                >
                  Leave
                </button>

                <!-- Remove Team Member -->
                <button
                  v-if="userPermissions.canRemoveTeamMembers && $page.props.user.id !== user.id"
                  class="cursor-pointer ml-6 text-sm text-red-500"
                  @click="confirmTeamMemberRemoval(user)"
                >
                  Remove
                </button>
              </div>
            </div>
          </div>
        </template>
      </JetActionSection>
    </div>

    <!-- Role Management Modal -->
    <JetDialogModal
      :show="currentlyManagingRole"
      @close="currentlyManagingRole = false"
    >
      <template #title> Manage Role </template>

      <template #content>
        <div v-if="managingRoleFor">
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
                'rounded-b-none': i !== Object.keys(availableRoles).length - 1,
              }"
              @click="updateRoleForm.role = role.key"
            >
              <div
                :class="{
                  'opacity-50':
                    updateRoleForm.role && updateRoleForm.role !== role.key,
                }"
              >
                <!-- Role Name -->
                <div class="flex items-center">
                  <div
                    class="text-sm text-gray-600"
                    :class="{
                      'font-semibold': updateRoleForm.role === role.key,
                    }"
                  >
                    {{ role.name }}
                  </div>

                  <svg
                    v-if="updateRoleForm.role === role.key"
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
                <div class="mt-2 text-xs text-gray-600">
                  {{ role.description }}
                </div>
              </div>
            </button>
          </div>
        </div>
      </template>

      <template #footer>
        <JetSecondaryButton @click="currentlyManagingRole = false">
          Cancel
        </JetSecondaryButton>

        <JetButton
          class="ml-3"
          :class="{ 'opacity-25': updateRoleForm.processing }"
          :disabled="updateRoleForm.processing"
          @click="updateRole"
        >
          Save
        </JetButton>
      </template>
    </JetDialogModal>

    <!-- Leave Team Confirmation Modal -->
    <JetConfirmationModal
      :show="confirmingLeavingTeam"
      @close="confirmingLeavingTeam = false"
    >
      <template #title> Leave Team </template>

      <template #content>
        Are you sure you would like to leave this team?
      </template>

      <template #footer>
        <JetSecondaryButton @click="confirmingLeavingTeam = false">
          Cancel
        </JetSecondaryButton>

        <JetDangerButton
          class="ml-3"
          :class="{ 'opacity-25': leaveTeamForm.processing }"
          :disabled="leaveTeamForm.processing"
          @click="leaveTeam"
        >
          Leave
        </JetDangerButton>
      </template>
    </JetConfirmationModal>

    <!-- Remove Team Member Confirmation Modal -->
    <JetConfirmationModal
      :show="teamMemberBeingRemoved"
      @close="teamMemberBeingRemoved = null"
    >
      <template #title> Remove Team Member </template>

      <template #content>
        Are you sure you would like to remove this person from the team?
      </template>

      <template #footer>
        <JetSecondaryButton @click="teamMemberBeingRemoved = null">
          Cancel
        </JetSecondaryButton>

        <JetDangerButton
          class="ml-3"
          :class="{ 'opacity-25': removeTeamMemberForm.processing }"
          :disabled="removeTeamMemberForm.processing"
          @click="removeTeamMember"
        >
          Remove
        </JetDangerButton>
      </template>
    </JetConfirmationModal>
  </div>
</template>
