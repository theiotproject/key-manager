<script setup>
import Link from "@inertiajs/inertia-vue3";
import Setup from "./Setup/Setup.vue";
</script>
<template>
  <section class="first flex flex-col items-center pb-32">
    <div class="flex items-center z-10">
      <img
        src="../../../../public/images/key_manager_logo.svg"
        class="mr-3 h-6 sm:h-9 scale-125"
        alt="logo"
      />
      <p class="text-2xl font-bold py-10 mb-2">Key Manager</p>
    </div>
    <transition name="slide" mode="out-in">
      <div v-if="!setup">
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
        v-else
        class="
          flex
          items-center
          justify-center
          h-screen
          w-screen
          absolute
          teamNameContainer
        "
      >
        <Setup
          :attrs="attrs"
          :team="createdTeam"
          :goToDashboard="goToDashboard"
        ></Setup>
      </div>
    </transition>
  </section>

  <div v-if="!setup" class="flex justify-center">
    <div class="circle">OR</div>
  </div>
  <section v-if="!setup" class="second flex flex-col items-center pb-32">
    <div class="w-128">
      <p class="font-semibold my-5">Accept an invitation</p>
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
            @mouseover="invitationHover = true"
            @mouseout="invitationHover = false"
          >
            <p>{{ invitation.team.name }}</p>
            <div class="flex items-center">
              <p v-if="invitationHover" class="font-bold text-orange-400">
                Join team
              </p>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 scale-125 transition-margin duration-75"
                :class="invitationHover ? '-mr-2 text-orange-400' : 'mr-0'"
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
            <!-- <button class="py-2 px-5 border border-gray-200 shadow rounded">
              Join
            </button> -->
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      attrs: this.$attrs,
      invitations: {},
      invitationHover: false,
      setup: false,
      setupStep: 1,
      createdTeam: Object,
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
    goToDashboard() {
      this.$inertia.get(this.route("dashboard"));
    },
  },
  created() {
    this.getInvitations();
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

.slide-enter-active,
.slide-leave-active {
  transition: all 0.3s ease;
}

.slide-enter-from,
.slide-leave-to {
  opacity: 0;
}
</style>
