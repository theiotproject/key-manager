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
        <!-- <p class="ml-3">{{ gate.name }}</p> -->

        <Link
          :href="route('dashboard')"
          class="flex items-center hover:text-gray-200"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.8"
            stroke="currentColor"
            class="w-7 h-7 ml-3 mr-2"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"
            />
          </svg>

          <p>Go back to dashboard</p>
        </Link>
      </h2>
    </div>
    <section class="mb-72 flex space-x-20 mt-2 p-10 parent">
      <gate-virtual-keys
        class="div1 secondColor stagger"
        :attrs="attrs"
        :gate="gate"
      />
      <events-widget
        class="max-h-200 div2 secondColor stagger"
        :attrs="attrs"
        :gate="gate"
      />
      <multi-axis-line-chart
        v-if="chartLoaded"
        class="div3 secondColor shadow-xl rounded-lg stagger"
        :chartData="chartData"
        :gate="gate"
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
      chartLoaded: false,
      chartData: {},
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
    getChartData() {
      axios
        .get(`/events/gateSN/${this.gate.serial_number}/count`)
        .then((response) => {
          this.chartData = {
            labels: response.data.labels,
            datasets: [
              {
                label: "Access Granted",
                backgroundColor: "green",
                data: response.data.accessGranted,
              },
              {
                label: "Access Denied",
                backgroundColor: "red",
                data: response.data.accessDenied,
              },
            ],
          };
          this.chartLoaded = true;
        });
    },
  },
  created() {
    this.getRole();
    this.getChartData();
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
