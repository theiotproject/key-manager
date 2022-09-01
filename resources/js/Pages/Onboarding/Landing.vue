<script setup>
import Link from "@inertiajs/inertia-vue3";
import Setup from "./Setup/Setup.vue";
import { Inertia } from "@inertiajs/inertia";

const switchToTeam = (team) => {
  Inertia.put(
    route("current-team.update"),
    {
      team_id: team.id,
    },
    {
      preserveState: false,
    }
  );
};
</script>
<template>
  <Head title="Welcome - Key Manager" />
  <section class="first flex flex-col items-center pb-32">
    <div class="flex items-center z-10">
      <img
        src="../../../../public/images/key_manager_logo.svg"
        class="mr-3 h-6 sm:h-9 scale-125"
        alt="logo"
      />
      <p class="text-2xl font-bold py-10 mb-2">Key Manager</p>
    </div>
    <transition name="smooth" mode="out-in">
      <div v-if="!setup && instant !== true">
        <div
          class="
            absolute
            right-20
            top-12
            bg-gray-200
            px-3
            py-1
            rounded-full
            opacity-70
            flex
            items-center
            gap-1
            text-sm
          "
        >
          <p>
            You are logged in as <b>{{ attrs.user.name }}</b>
          </p>
          <p class="italic cursor-pointer hover:underline" @click="logout">
            Log out
          </p>
        </div>
        <div class="flex items-center max-w-4xl mt-16">
          <div class="w-1/2">
            <h1 class="text-4xl font-semibold my-4">Create a new team</h1>
            <p>
              Key Manager gives your team a home - a place where they manage
              virtual keys together. To create a new team, click the button
              below.
            </p>
            <button
              @click="createTeam"
              class="
                mt-5
                bg-blue-500
                hover:bg-blue-400
                text-white
                font-bold
                py-2
                px-4
                border-b-4 border-blue-700
                hover:border-blue-500
                rounded
              "
            >
              Create a Team
            </button>
          </div>
          <div class="w-1/2">
            <img
              src="../../../../public/images/qrcodebusiness.jpg"
              alt="QR Code business"
            />
          </div>
        </div>
      </div>
      <div
        v-else-if="setup"
        class="flex justify-center h-screen p-0 m-0 w-screen teamNameContainer"
      >
        <Setup :attrs="attrs" :team="createdTeam"></Setup>
      </div>
    </transition>
  </section>

  <div v-if="!setup && instant !== true" class="flex justify-center">
    <div class="circle">OR</div>
  </div>
  <section v-if="!setup && instant !== true" class="second flex flex-col items-center pb-32">
    <div class="w-128">
      <div v-if="$page.props.user.all_teams.length > 0">
        <p class="font-semibold my-5">Open a team</p>
        <div
          class="
            w-full
            border border-gray-200
            shadow-lg
            rounded
            overflow-hidden
          "
        >
          <div class="p-5 text-sm border-b border-gray-200">
            Teams for <b>{{ attrs.user.email }}</b>
          </div>
          <div>
            <template
              v-for="(team, index) in $page.props.user.all_teams"
              :key="team.id"
            >
              <div
                v-if="index < 3 && showAllTeams === false"
                @click="switchToTeam(team)"
                class="
                  z-20
                  p-7
                  text-sm
                  border-b border-gray-200
                  font-bold
                  flex
                  items-center
                  justify-between
                  hover:bg-gray-50
                  cursor-pointer
                "
                @mouseover="teamHover = team.id"
                @mouseleave="teamHover = null"
              >
                <p @mouseover="teamHover = team.id">
                  {{ team.name }}
                </p>
                <div class="flex items-center" @mouseover="teamHover = team.id">
                  <p
                    v-if="teamHover === team.id"
                    class="font-bold text-orange-400 z-30"
                    @mouseover="teamHover = team.id"
                  >
                    Open
                  </p>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 scale-125 transition-margin duration-75"
                    :class="
                      teamHover === team.id ? '-mr-2 text-orange-400' : 'mr-0'
                    "
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M13 7l5 5m0 0l-5 5m5-5H6"
                    />
                  </svg>
                </div>
              </div>
              <div
                v-else-if="showAllTeams === true"
                @click="switchToTeam(team)"
                class="
                  z-20
                  p-7
                  text-sm
                  border-b border-gray-200
                  font-bold
                  flex
                  items-center
                  justify-between
                  hover:bg-gray-50
                  cursor-pointer
                "
                @mouseover="teamHover = team.id"
                @mouseleave="teamHover = null"
              >
                <p @mouseover="teamHover = team.id">
                  {{ team.name }}
                </p>
                <div class="flex items-center" @mouseover="teamHover = team.id">
                  <p
                    v-if="teamHover === team.id"
                    class="font-bold text-orange-400 z-30"
                    @mouseover="teamHover = team.id"
                  >
                    Open
                  </p>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 scale-125 transition-margin duration-75"
                    :class="
                      teamHover === team.id ? '-mr-2 text-orange-400' : 'mr-0'
                    "
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M13 7l5 5m0 0l-5 5m5-5H6"
                    />
                  </svg>
                </div>
              </div>
            </template>
            <div
              @click="showAllTeams = !showAllTeams"
              v-if="$page.props.user.all_teams.length > 3"
              class="
                pl-7
                py-5
                font-light
                cursor-pointer
                text-sm
                hover:underline
              "
            >
              <div v-if="showAllTeams === false" class="flex items-center">
                <p>
                  Show {{ $page.props.user.all_teams.length - 3 }} more teams
                </p>
                <!-- <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-3 w-3 ml-2"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  stroke-width="2"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M19 9l-7 7-7-7"
                  />
                </svg> -->
              </div>
              <div v-else>Show fewer teams</div>
            </div>
          </div>
        </div>
      </div>
      <p class="font-semibold my-5 mt-10">Accept an invitation</p>
      <div class="w-full h-96 border border-gray-200 shadow-lg rounded">
        <div class="p-5 text-sm border-b border-gray-200">
          Invitations for <b>{{ attrs.user.email }}</b>
        </div>
        <div v-if="invitations == 0" class="text-center mt-20 font-bold">
          You don't have any invitations
        </div>
        <div>
          <div
            v-for="invitation in invitations"
            :key="invitation.id"
            @click="joinTeam(invitation.id)"
            class="
              z-20
              p-7
              text-sm
              border-b border-gray-200
              font-bold
              flex
              items-center
              justify-between
              hover:bg-gray-50
              cursor-pointer
            "
            @mouseover="invitationHover = invitation.id"
            @mouseleave="invitationHover = null"
          >
            <p @mouseover="invitationHover = invitation.id">
              {{ invitation.team.name }}
            </p>
            <div
              class="flex items-center"
              @mouseover="invitationHover = invitation.id"
            >
              <p
                v-if="invitationHover === invitation.id"
                class="font-bold text-orange-400 z-30"
                @mouseover="invitationHover = invitation.id"
              >
                Join team
              </p>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 scale-125 transition-margin duration-75"
                :class="
                  invitationHover === invitation.id
                    ? '-mr-2 text-orange-400'
                    : 'mr-0'
                "
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M13 7l5 5m0 0l-5 5m5-5H6"
                />
              </svg>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
    props: ['instant'],
  data() {
    return {
        instant: this.instant,
      attrs: this.$attrs,
      invitations: {},
      invitationHover: null,
      teamHover: null,
      setup: false,
      setupStep: 1,
      createdTeam: Object,
      showAllTeams: false,
    };
  },
  methods: {
    async createTeam() {
      await axios
        .post(`/api/teams/create`, {
          name: this.attrs.user.name.split(" ", 2)[0] + "'s" + " team",
        })
        .then((response) => {
          this.renderSetup();
          this.createdTeam = response.data;
          this.attrs.user.current_team = response.data;
        });
    },
    renderSetup() {
      document.body.style.backgroundColor = "#f7f7f7";
      this.setup = true;
      setTimeout(function () {
        document.body.style.backgroundColor = "white";
      }, 2000);
    },
    getInvitations() {
      axios.get(`/teams/invitations/${this.attrs.user.id}`).then((response) => {
        this.invitations = response.data;
      });
    },
    joinTeam(invitationId) {
      axios.post(`/api/teams/join`, { invitationId: invitationId });
      this.$inertia.get(this.route("dashboard"));
    },
    logout() {
      this.$inertia.post(route("logout"));
    },
  },
  created() {
    this.getInvitations();
      if(this.instant === true) this.createTeam();
  },
};
</script>

<style scoped>
* {
  font-family: "montserrat";
}

.first,
.teamNameContainer {
  background-color: #f7f7f7;
}

.firstColor {
  background-color: #f7f7f7;
}

.circle {
  background-color: white;
  border-radius: 100%;
  padding: 20px;
  font-weight: 500;
  position: relative;
  bottom: 31px;
}

.smooth-enter-active,
.smooth-leave-active {
  transition: all 0.3s ease;
}

.smooth-enter-from,
.smooth-leave-to {
  opacity: 0;
}
</style>
