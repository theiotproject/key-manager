import { defineComponent, h, PropType } from 'vue'

import { Line } from 'vue-chartjs'
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    LinearScale,
    PointElement,
    CategoryScale,
    Plugin
} from 'chart.js'

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    LineElement,
    LinearScale,
    PointElement,
    CategoryScale
)

export default defineComponent({
    name: 'LineChart',
    components: {
        Line
    },
    props: {
        chartId: {
            type: String,
            default: 'line-chart'
        },
        width: {
            type: Number,
            default: 400
        },
        height: {
            type: Number,
            default: 400
        },
        cssClasses: {
            default: '',
            type: String
        },
        styles: {
            type: Object as PropType<Partial<CSSStyleDeclaration>>,
            default: () => { }
        },
        plugins: {
            type: Array as PropType<Plugin<'line'>[]>,
            default: () => []
        }
    },
    setup(props) {
        const chartData = {
            labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            datasets: [
                {
                    label: 'Access Granted',
                    backgroundColor: 'green',
                    data: [40, 39, 10, 40, 39, 80, 40]
                },
                {
                    label: 'Access Denied',
                    backgroundColor: 'red',
                    data: [20, 10, 5, 10, 2, 12, 20]
                }
            ]
        }

        let start = new Date(),
            end = new Date();

        start.setDate(start.getDate() - 7); // set to 'now' minus 7 days.
        start.setHours(0, 0, 0, 0); // set to midnight.

        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Last 7 days gate usage'
                }
            }
        }
        //     scales: {
        //         xAxes: [{
        //             type: "time",
        //             time: {
        //                 min: start,
        //                 max: end,
        //                 unit: "day"
        //             }
        //         }]
        //     }
        // }

        return () =>
            h(Line, {
                chartData,
                chartOptions,
                chartId: props.chartId,
                width: props.width,
                height: props.height,
                cssClasses: props.cssClasses,
                styles: props.styles,
                plugins: props.plugins
            })
    }
})
