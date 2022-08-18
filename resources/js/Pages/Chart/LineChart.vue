<template>
  <Line v-if="loaded" :chart-data="chartData" />
</template>

<script>
import { Line } from "vue-chartjs";
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from "chart.js";

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
);

export default {
  name: "LineChart",
  components: { Line },
  data: () => ({
    loaded: false,
    chartData = [
            labels= [],
            datasets= [
                {
                    label: 'Access Granted',
                    backgroundColor: 'green',
                    data: []
                },
                {
                    label: 'Access Denied',
                    backgroundColor: 'red',
                    data: []
                }
            ]
    ]
  }),
  async mounted() {
    this.loaded = false;

    try {
      const { data } = await fetch("/events/gateSN/9238420983/count");
      this.chartdata = data;

      this.loaded = true;
    } catch (e) {
      console.error(e);
    }
  },
};
</script>
