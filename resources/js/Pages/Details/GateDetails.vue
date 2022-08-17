<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import MultiAxisLineChart from "../Chart/MultiAxisLineChart";
import EventsWidget from "./GateEvents.vue";
import GateVirtualKeys from "./GateVirtualKeys.vue";
</script>
<template>
  <div class="overflow-hidden shadow-xl sm:rounded-lg container">
    <div class="flex justify-between bg-gradient-to-r from-blue-500 to-sky-400">
      <h2
        class="
          m-7
          py-2
          mt-3
          text-white
          font-bold
          text-xl
          mb-2
          flex
          items-center
        "
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-5 w-5 ml-2"
          viewBox="0 0 20 20"
          fill="#FFA500"
        >
          <path
            fill-rule="evenodd"
            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
            clip-rule="evenodd"
          />
        </svg>
        <p class="ml-3">{{ gate.name }}</p>
      </h2>
      <div class="flex items-center mr-5">
        <Link
          v-if="role === 'owner' || role === 'admin'"
          class="cursor-pointer ml-6 text-sm text-blue-500 hover:text-blue-700"
          :href="route('gates.edit', [gate])"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
            />
          </svg>
        </Link>
        <button
          v-if="role === 'owner' || role === 'admin'"
          class="cursor-pointer ml-6 text-sm text-red-500 hover:text-red-700"
          @click="confirmGateRemoval(gate)"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
            />
          </svg>
        </button>
      </div>
    </div>
    <section class="mb-72 flex space-x-20 mt-10 p-10 parent">
      <gate-virtual-keys
        class="div1 secondColor stagger"
        :attrs="attrs"
        :virtualKeys="virtualKeys"
      />
      <events-widget
        class="max-h-200 div2 secondColor stagger"
        :attrs="attrs"
        :gate="gate"
      />
      <multi-axis-line-chart
        class="div3 secondColor shadow-xl rounded-lg stagger"
      />
    </section>
  </div>
</template>
<script>
import gsap from "gsap";
export default {
  props: ["attrs", "gate"],
  data() {
    return {
      gate: this.gate,
      virtualKeys: {},
      localAttrs: this.attrs,
      role: "",
    };
  },
  methods: {
    getRole() {
      axios
        .get(`/auth/role/teamId/${this.localAttrs.user.current_team_id}`)
        .then((response) => {
          this.role = response.data;
        })
        .catch((err) => {
          MakeToast.create("Cannot load role", "error");
        });
    },
    getVirtualKeys() {
      axios.get(`/virtualKeys/gate/${this.gate.id}`).then((response) => {
        this.virtualKeys = response.data;
      });
    },
  },
  created() {
    this.getRole();
    this.getVirtualKeys();
  },
  mounted() {
    gsap.from(".stagger", {
      duration: 0.3,
      opacity: 0,
      transform: "translateY(40px)",
      ease: "power1",
      stagger: 0.2,
    });
  },
};
</script>
<style scoped>
.container {
  background-color: #f7f7f7f;
}

.secondColor {
  background-color: white;
}

.parent {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  grid-template-rows: repeat(2, 1fr);
  grid-column-gap: 20px;
  grid-row-gap: 20px;
}

.div1 {
  grid-area: 1 / 1 / 2 / 2;
}
.div2 {
  grid-area: 1 / 2 / 3 / 3;
  margin-left: 0 !important;
}
.div3 {
  grid-area: 2 / 1 / 3 / 2;
  margin-left: 0 !important;
  padding: 20px;
}
</style>
