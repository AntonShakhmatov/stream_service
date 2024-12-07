<template>
    <MainLayout>
        <RoomVideo v-if="roomVideo?._id" @roomVideoClose="closeRoomVideo"/>
        <div class="mt-2 lg:mt-12 min-h-screen flex gap-20">
            <div class="hidden lg:block">
                <h1 class="text-white text-3xl font-medium">Statistics</h1>
                <StatsSideBar :room-name="roomName" v-if="isLoading"/>
            </div>
            <main class="flex-grow flex flex-col gap-2" v-if="isLoading">
                <div class="flex flex-wrap mb-20 lg:hidden">
                    <h1 class="text-white text-3xl font-medium">Statistics</h1>
                    <StatsSideBar :room-name="roomName" v-if="isLoading"/>
                </div>
                <div class="flex">
                    <div class="flex gap-5">
                        <BaseButton
                            :class="showOffLineRooms === 'true'  ? 'bg-secondary-color' : '!bg-primary-color'"
                            @click="changeShowPlots('offLineRooms')"
                        >
                            Show online rooms only
                        </BaseButton>

                        <BaseButton
                            :class="plots === true || plots === 'true' ? '!bg-primary-color' : 'bg-secondary-color'"
                            @click="changeShowPlots('plots')"
                        >
                            Show plots
                        </BaseButton>
                    </div>

                    <MainFilter class="ml-auto flex gap-5"/>
                </div>

                <div class="flex mt-10 grid xl:grid-cols-3 gap-6 grid-cols-1 p-10 bg-black"
                     v-if="plots === true || plots === 'true'">
                    <div
                        class="w-full aspect-4/3 bg-primary bg-cover bg-no-repeat rounded-md transition-all cursor-pointer overflow-hidden relative">
                        <StatsChart :labels="['Americans', 'Australia', 'Africa', 'Europe', 'Asia']"
                                    center-text="Followers in continents"/>
                    </div>
                    <div
                        class="w-full aspect-4/3 bg-primary bg-cover bg-no-repeat rounded-md transition-all cursor-pointer overflow-hidden relative">
                        <StatsChart :labels="['16-20', '21-30', '31-40', '41-50', '51-99']"
                                    center-text="Followers in age groups"/>
                    </div>
                    <div
                        class="w-full aspect-4/3 bg-primary bg-cover bg-no-repeat rounded-md transition-all cursor-pointer overflow-hidden relative">
                        <StatsChart :labels="['Slim', 'Athletic', 'Average', 'Curvy', 'BBW']"
                                    center-text="Followers in body types"/>
                    </div>
                </div>

                <section class="mt-10 h-[20rem] lg:grid-cols-3 grid grid-cols-1 gap-4 flex items-end">

                    <StatsRoom
                        :room="getRoom(1)"
                        :className="'!h-[90%]'"
                        :rank="2"
                    />

                    <StatsRoom
                        :room="getRoom(0)"
                        :className="'!h-full'"
                        :rank="1"
                    />

                    <StatsRoom
                        :room="getRoom(2)"
                        class="!h-[90%]"
                        :rank="3"
                    />
                </section>

                <section >
                    <div class="flex items-center">
                        <h1 class="mt-6 text-white text-xl font-bold mb-3">Leadeboard</h1>
                        <div class="ml-auto flex gap-2">
                            <font-awesome-icon
                                :icon="['fas', 'table-cells-large']"
                                class="p-2 h-4 w-4 inline-block text-white rounded-md bg-background-secondary cursor-pointer transition-all hover:opacity-75"
                                :class="{'bg-primary-color': selectedLayout === 'grid'}"
                                @click="changeLayout('grid')"
                            />

                            <font-awesome-icon
                                :icon="['fas', 'list']"
                                class="p-2 h-4 w-4 inline-block text-white rounded-md bg-background-secondary cursor-pointer transition-all hover:opacity-75"
                                :class="{'bg-primary-color': selectedLayout === 'table'}"
                                @click="changeLayout('table')"
                            />

                        </div>
                    </div>

                    <EmptyRooms v-if="rooms.data.length === 0"/>
                    <RoomModal v-if="roomModal"  />

                    <div>
                        <StatsTable :rooms="rooms" v-if="selectedLayout === 'table'"/>
                        <RoomsResizableGrid
                            v-if="selectedLayout === 'grid'"
                            :compact="true"
                            :rooms="rooms.data"
                            :grid-size="1"
                        />
                        <Pagination v-if="rooms" :rooms="rooms" class="flex justify-end items-center mt-10" />
                    </div>

                    <!--        {loadMoreButtonIsVisible && (-->
<!--                    <div class="flex items-center justify-center mt-5 ">-->
<!--                        <BaseButton-->
<!--                            @click="loadMore"-->
<!--                            class="h-10 hover:cursor-pointer"-->
<!--                        >-->
<!--                            {{ isPaginatorLoading ? 'Loading...' : 'Load more' }}-->
<!--                        </BaseButton>-->
<!--                    </div>-->
                </section>
            </main>
        </div>
    </MainLayout>
</template>

<script>
import MainLayout from "@/views/layouts/MainLayout.vue";
import BaseButton from "@/components/partials/BaseButton.vue";
import RoomCell from "@/components/frontend/RoomCell.vue";
import EmptyRooms from "@/components/frontend//EmptyRooms.vue";
import RoomsResizableGrid from "@/components/frontend//RoomsResizableGrid.vue";
import MainFilter from "@/components/frontend//MainFilter.vue";
import StatsTable from "@/components/frontend//StatsTable.vue";
import StatsSideBar from "@/components/navigations/StatsSideBar.vue";
import StatsChart from "@/components/frontend//StatsChart.vue";
import {mapActions, mapGetters} from "vuex";
import RoomVideo from "@/components/frontend/RoomVideo.vue";
import RoomModal from "@/components/frontend/modals/RoomModal.vue";
import RoomItem from "@/components/frontend/RoomItem.vue";
import StatsRoom from "@/components/frontend/stats/StatsRoom.vue";
import Pagination from "@/components/frontend/Pagination.vue";

export default {
    name: "Stats",
    components: {
        StatsRoom,
        RoomItem,
        RoomModal,
        StatsChart,
        StatsSideBar,
        StatsTable,
        MainFilter,
        RoomsResizableGrid,
        EmptyRooms,
        RoomCell,
        BaseButton,
        MainLayout,
        RoomVideo,
        Pagination
    },
    data() {
        return {
            selectedLayout: 'grid',
            isLoading: false,
            rooms: [],
            plots: false,
            showOfflineRooms: false,
            roomName: '',
            page: 1,
            isPaginatorLoading: false,
            roomVideo: [],
            roomModal: [],
        }
    },
    async created() {
        this.page = this.$route?.query?.page ? this.$route.query?.page : 1;
        this.roomName = this.$route.params.room;

        await this.fetchStatsRooms(this.$route.params.room);
        this.rooms = this.getStatsRooms;

        this.isLoading = true;
    },
    computed: {
        ...mapGetters([
            "getStatsRooms",
            "getRoomVideo",
            "getRoomModal",
        ]),
    },
    methods: {
        ...mapActions([
            "fetchStatsRooms",
        ]),
        getRoom(roomIndex) {
            let returnRoom = {};
            this.rooms.data.forEach((room, idx) => {
                if (idx === roomIndex) {
                    returnRoom = room;
                }
            });
            return returnRoom;
        },
        changeLayout(layout) {
            this.selectedLayout = layout;
        },
        async loadMore() {
            if (this.rooms.next_page_url) {
                const $page = this.rooms.next_page_url.substring(this.rooms.next_page_url.length - 1)

                await this.fetchRooms($page);
                this.rooms = this.getRooms;
            }
        },
        changeShowPlots(val) {
            if (val === 'plots') {
                this.plots = !this.plots;
            } else {
                this.showOfflineRooms = !this.showOfflineRooms
            }
            this.getFilteredData();
        },
        getFilteredData() {

        },
        closeRoomVideo() {

        }
    },
    watch: {
        '$route.params': function () {
            this.fetchStatsRooms(this.$route.params.room);
            this.rooms = this.getStatsRooms;
        },
        'getRoomVideo': function () {
            this.roomVideo = this.getRoomVideo;
        },
        'getRoomModal': function () {
            this.roomModal = this.getRoomModal;
        }
    }
}
</script>

<style scoped>

</style>
