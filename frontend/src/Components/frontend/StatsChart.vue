<template>
    <Doughnut :data="data" :options="options" />
    <div style="transform: translate(-50%,-50%);overflow-wrap: break-word;text-align: center;" class="text-white text-3xl md:text-lg xl:w-[100px] absolute top-1/2 left-1/2 w-[150px] mr-[-50%]">
        {{ centerText }}
    </div>
</template>

<script>

import { Chart as ChartJS, ArcElement, Tooltip } from 'chart.js'
import { Doughnut } from 'vue-chartjs'
import ChartJsPluginDataLabels from "chartjs-plugin-datalabels";

ChartJS.register(ArcElement, Tooltip, ChartJsPluginDataLabels)

export default {
    name: "StatsChart",
    components: {
        Doughnut,
    },
    props: {
        labels: [],
        centerText: String,
    },
    data() {
        return {
            data: {
                labels: this.labels,
                datasets: [
                    {
                        backgroundColor: ['#41B883', '#E46651', '#00D8FF', '#e8bfbe', '#e54a71'],
                        data: [40, 20, 40, 10,20]
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                segmentShowStroke : false,
                percentageInnerCutout : 90,
                plugins: {
                    legend: {
                        display: false
                    },
                    datalabels: {
                        labels: {
                            value: {},
                            title: {
                                color: 'white'
                            }
                        },
                        anchor: 'end',
                        align: 'end',
                        clamp: true,
                        padding: 0,
                        font: {
                            weight: 'normal',
                            size: '18'
                        },
                        formatter: function(value, context) {
                            return context.chart.data.labels[context.dataIndex];
                        }
                    }
                }
            }
        }
    },
    created() {
    }
}
</script>

<style scoped>

</style>
