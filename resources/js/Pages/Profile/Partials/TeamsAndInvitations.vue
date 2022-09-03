<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetFormSection from '@/Jetstream/FormSection.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetSectionBorder from "@/Jetstream/SectionBorder.vue";
import JetActionSection from "@/Jetstream/ActionSection.vue";
import {Inertia} from "@inertiajs/inertia";

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
    <div
        v-if="invitations.length > 0"
    >

        <!-- Team Member Invitations -->
        <JetActionSection class="mt-10 sm:mt-0">
            <template #title> Pending Team Invitations <span class="text-red-500">({{invitations.length}})</span></template>

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
                        <div class="text-gray-600 font-medium flex items-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path d="M4.5 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM14.25 8.625a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM17.25 19.128l-.001.144a2.25 2.25 0 01-.233.96 10.088 10.088 0 005.06-1.01.75.75 0 00.42-.643 4.875 4.875 0 00-6.957-4.611 8.586 8.586 0 011.71 5.157v.003z" />
                            </svg>
                            <p class="ml-2">{{ invitation.team.name }}</p>
                        </div>

                        <div class="flex items-center">
                            <button
                                @mouseenter="acceptHover = invitation.id"
                                @mouseleave="acceptHover = null"
                                class="
                    cursor-pointer
                    ml-6
                    text-sm text-green-500
                    focus:outline-none
                  "
                                @click="joinTeam(invitation.id)"
                            >
                                <svg v-if="acceptHover === invitation.id" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                            <button
                                class="
                    cursor-pointer
                    ml-3
                    text-sm text-red-500
                    focus:outline-none
                  "
                                @mouseover="rejectHover = invitation.id"
                                @mouseleave="rejectHover = null"
                                @click="deleteInvitation(invitation.id)"
                            >

                                <svg v-if="rejectHover === invitation.id" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
                                </svg>

                                <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>

                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </JetActionSection>
        <JetSectionBorder />
    </div>



    <JetFormSection @submitted="updatePassword">
        <template #title>
            Your teams
        </template>

        <template #description>
            Here you can see your team, click one of them to switch current team
        </template>

        <template #form>
    <div v-if="$page.props.user.all_teams.length > 0" class="col-span-6 sm:col-span-4">
        <div
            class="
            w-full
            border border-gray-200
            rounded-lg
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
                    </div>
                    <div v-else>Show fewer teams</div>
                </div>
            </div>
        </div>
        <JetButton class="mt-6" @click="createTeam()">
            Create new team
        </JetButton>
    </div>
        </template>
    </JetFormSection>
</template>
<script>
export default {
    props: ["attrs"],
    data() {
        return {
            attrs: this.attrs,
            invitations: {},
            invitationHover: null,
            teamHover: null,
            setup: false,
            setupStep: 1,
            createdTeam: Object,
            showAllTeams: false,
            acceptHover: false,
            rejectHover: false,
        };
    },
    methods: {
        createTeam() {
            this.$inertia.get(route('team.create'));
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
        getTeams() {
            axios.get(`/api/teams/userId/${this.attrs.user.id}`).then((response) => {
                this.$page.props.user.all_teams = response.data;
            })
        },
        joinTeam(invitationId) {
            axios.post(`/api/teams/join/switch/0`, { invitationId: invitationId });
            this.getInvitations();
            this.getTeams();
        },
        deleteInvitation(invitationId) {
            axios.delete(`/teams/invitation/${ invitationId }`).then((response) => {
                this.getInvitations();
            });
        },
        logout() {
            this.$inertia.post(route("logout"));
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

.smooth-enter-active,
.smooth-leave-active {
    transition: all 0.3s ease;
}

.smooth-enter-from,
.smooth-leave-to {
    opacity: 0;
}
</style>
