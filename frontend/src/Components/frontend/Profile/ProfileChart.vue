<template>
    <div class="w-max-screen">
        <h3 class="title my-5">Stats</h3>
        <select :disabled="!roomStats" @change="changeSelect" v-model="selectedOption">
            <option :value="options.value" v-for="options in selectOptions">{{ options.label }}</option>
        </select>
        <div class="mt-5">
            <div class="h-[300px]">
                <Line
                    key="viewers"
                    :data="viewersData"
                    :options="{
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Viewers'
                            },
                        },
                    }"
                    height="500"
                />
            </div>

            <hr class="my-5 text-primary" />

            <div class="h-[300px]">
                <Line
                    key="onlineTimes"
                    :data="onlineTimeData"
                    :options="{
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Online times'
                            }
                        }
                    }"
                />
            </div>
        </div>
    </div>
</template>

<script>

import { Chart as ChartJS, Tooltip, Legend, CategoryScale, LinearScale, PointElement, LineElement } from 'chart.js';
import { Line } from 'vue-chartjs';
import {mapActions, mapGetters} from "vuex";

ChartJS.register(Tooltip, Legend, CategoryScale, LinearScale, PointElement, LineElement);

export default {
    name: "ProfileChart",
    components: {
        Line,
    },
    props: {
        room: Object,
        roomStats: Object,
    },
    created() {
        this.viewersData = {
            labels: this.roomStats?.labels || [],
            datasets: this.roomStats?.template?.viewers || []
        };
        this.onlineTimeData = {
            labels: this.roomStats?.labels || [],
            datasets: this.roomStats?.template?.online_times || []
        };
    },
    methods: {
        ...mapActions([
            "fetchProfileRoomStats"
        ]),
        changeSelect() {
            this.getStatsData();
        },
        async getStatsData() {
            await this.fetchProfileRoomStats(this.selectedOption);
            this.stats = this.getProfileRoomStats;

            this.viewersData = {
                labels: this.stats?.labels || [],
                datasets: this.stats?.template.viewers || []
            };
            this.onlineTimeData = {
                labels: this.stats?.labels || [],
                datasets: this.stats?.template.online_times || []
            };
        }
    },
    computed: {
        ...mapGetters([
            "getProfileRoomStats",
        ]),
    },
    data() {
        return {
            selectOptions: [
                {
                    label: 'Last 7 days',
                    value: 7,
                },
                {
                    label: 'Last 30 days',
                    value: 30,
                },
                {
                    label: 'Last 60 days',
                    value: 60,
                },
                {
                    label: 'Last 90 days',
                    value: 90,
                },
            ],
            selectedOption: 7,
            viewersData: {},
            onlineTimeData: {},
            defaultOnlineData: [],
            defaultViewersData: {
                labels: this.roomStats?.labels || [],
                datasets: this.roomStats?.template.viewers || []
            },
            stats: [],
        }
    }

}
</script>

<style scoped>

</style>
