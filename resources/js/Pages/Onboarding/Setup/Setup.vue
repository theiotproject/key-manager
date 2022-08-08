<script setup>
import TeamName from "./TeamName.vue";
import InviteTeamMember from "./InviteTeamMembers.vue";
</script>
<template>
  <transition name="slide" mode="out-in">
    <TeamName v-if="step === 1" :nextStep="nextStep"></TeamName>
    <InviteTeamMember v-else-if="step === 2"></InviteTeamMember>
  </transition>
</template>
<script>
export default {
  data() {
    return {
      step: 1,
    };
  },
  methods: {
    nextStep() {
      this.step++;
    },
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

