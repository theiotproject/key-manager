<script setup>
import TeamName from "./TeamName.vue";
import InviteTeamMembers from "./InviteTeamMembers.vue";
</script>
<template>
  <transition name="slide" mode="out-in">
    <TeamName
      v-if="step === 1"
      @nextStep="nextStepFromChild"
      :attrs="attrs"
      :team="team"
      @newTeamName="getTeam"
    ></TeamName>
    <InviteTeamMembers
      v-else-if="step === 2"
      :attrs="attrs"
      :team="team"
      :newTeamName="newTeamName"
    ></InviteTeamMembers>
  </transition>
</template>
<script>
export default {
  props: ["attrs", "team"],
  data() {
    return {
      step: 1,
      attrs: this.attrs,
      team: this.team,
        newTeamName: ''
    };
  },
  methods: {
    nextStepFromChild() {
      this.step++;

    },
      getTeam(teamName){
        this.newTeamName = teamName;
      }
  },
};
</script>
<style scoped>
.slide-enter-active,
.slide-leave-active {
  transition: all 0.3s ease;
}

.slide-enter-from,
.slide-leave-to {
  opacity: 0;
  transform: translateY(10px);
}
</style>

