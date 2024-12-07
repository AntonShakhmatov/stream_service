<template>
    <MainLayout>
        <RoomVideo v-if="roomVideo?._id"/>
        <TopRated/>
        <div class="md:flex grid grid-cols-2 mt-5">
            <div class="mb-5 md:w-72 h-screen md:sticky top-0 bg-secondary-color rounded-md overflow-y-scroll">
                <table class="w-full table-fixed max-h-screen overflow-y-scroll">
                    <thead>
                    <tr class="bg-primary-color text-white text-left">
                        <th
                            class="p-2 cursor-pointer"
                            @click="orderedTags"
                        >
                            Tag
                            <font-awesome-icon :icon="['fas', 'fa-sort-up']" v-show="orderTags === 'descending'"/>

                            <font-awesome-icon :icon="['fas', 'fa-sort-down']" v-show="orderTags === 'ascending'"/>
                        </th>
                        <th
                            class="p-2 cursor-pointer"
                            @click="orderNumberTags"
                        >
                            Rooms
                            <font-awesome-icon :icon="['fas', 'fa-sort-up']" v-show="numberOrderTags === 'descending'"/>
                            <font-awesome-icon :icon="['fas', 'fa-sort-down']"
                                               v-show="numberOrderTags === 'ascending'"/>
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-for="(tag, idx) in tagList.data"
                        @click="setSelectedTag(tag.name)"
                        class='cursor-pointer text-white font-bold'
                        :class="[idx % 2 !== 0 ? 'bg-third-color' : 'bg-secondary-color', filter.tag.includes(tag.name) && '!bg-primary-color']"
                    >
                        <td class="p-2 whitespace-nowrap overflow-hidden overflow-ellipsis">
                            {{ tag.name }}
                        </td>
                        <td class="p-2">{{ tag.count }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="w-full ml-5">
                <p class="text-white">{{ rooms?.total }} filtered rooms out of - {{ roomsCount }}</p>
                <div class="flex justify-between">
                    <ActiveFilters :filter="filter" @resetFilter="resetFilter" />
                    <div class="flex h-[43px]">
                        <Pagination v-if="rooms" :rooms="rooms" class="h-[43px]"/>
                        <GridResize class="my-5 md:my-0" :value="gridSize" @input="setGridSize"/>
                    </div>
                </div>

                <EmptyRooms className="w-full m-auto" v-if="rooms?.data?.length === 0"/>

                <RoomsResizableGrid v-if="rooms?.data" :rooms="rooms?.data" :grid-size="gridSize"/>
            </div>

            <RoomModal v-if="roomModal" :open="roomModalOpen" @closeModal="closeRoomModal"/>
            <NotesModal />
        </div>
        <Pagination v-if="rooms" :rooms="rooms" class="flex justify-end items-center mt-10" />

    </MainLayout>
</template>

<script>
import MainLayout from "@/views/layouts/MainLayout.vue";
import TopRated from "@/components/frontend/TopRated.vue";
import GridResize from "@/components/frontend/GridResize.vue";
import ActiveFilters from "@/components/frontend/ActiveFilters.vue";
import EmptyRooms from "@/components/frontend/EmptyRooms.vue";
import RoomsResizableGrid from "@/components/frontend/RoomsResizableGrid.vue";
import RoomVideo from "@/components/frontend/RoomVideo.vue";
import Pagination from "@/components/frontend/Pagination.vue";
import RoomModal from "@/components/frontend/modals/RoomModal.vue";
import {mapGetters, mapActions, mapMutations} from 'vuex'
import NotesModal from "@/components/frontend/modals/NotesModal.vue";
import _ from "lodash";

export default {
    name: "Tags",
    components: {
        MainLayout,
        EmptyRooms,
        RoomsResizableGrid,
        RoomVideo,
        RoomModal,
        NotesModal,
        TopRated,
        ActiveFilters,
        Pagination,
        GridResize,
    },
    data() {
        return {
            tagList: [],
            filter: [],
            orderTags: 'descending',
            numberOrderTags: 'descending',
            rooms: [],
            page: 0,
            gridSize: 2,
            roomVideo: [],
            roomsCount: 0,
            roomModal: [],
            roomModalOpen: false,
        }
    },
    async created() {
        this.page = this.$route.query?.page ? this.$route.query?.page : 1;
        await this.fetchTags();
        this.setActiveFilter();

        await this.fetchRooms({page: this.page, filter: this.getActiveFilter});
        this.tagList = this.getTags;
        this.filter = this.getActiveFilter;

        this.roomsCount = this.getAllOnlineRooms;
    },
    methods: {
        ...mapActions([
            'fetchTags',
            "fetchRooms",
        ]),
        ...mapMutations([
            "setFilterWithQuery",
        ]),

        orderedTags() {
            const tagsCopy = this.tagList.data;

            this.orderTags = this.orderTags === "descending" ? "ascending" : "descending";
            return this.orderTags === "descending" ? tagsCopy.sort((a, b) => a.name.localeCompare(b.name) * -1) : tagsCopy.sort((a, b) => a.name.localeCompare(b.name));
        },
        orderNumberTags() {
            const tagsCopy = this.tagList.data;
            this.numberOrderTags = this.numberOrderTags === "descending" ? "ascending" : "descending";

            return this.numberOrderTags === "descending" ? tagsCopy.sort((a, b) => b.count - a.count) : tagsCopy.sort((a, b) => a.count - b.count);
        },
        async setSelectedTag(val) {
            if (_.includes(this.filter?.tag, val)) {
                this.filter.tag = this.filter.tag.filter((el) => el !== val);
            } else {
                this.filter?.tag.push(val);
            }

            await this.fetchRooms({page: this.page, filter: this.filter});
            this.setActiveFilter();
            this.rooms = this.getRooms;
        },
        setGridSize(val) {
            this.gridSize = val;
        },
        async setActiveFilter() {
            await this.setFilterWithQuery(new URLSearchParams(this.$route.query));
            this.filter = this.getActiveFilter;
        },
        resetFilter() {
            this.getFilteredData();
        },
        getFilteredData() {
            this.fetchRooms({page: this.page, filter: this.getActiveFilter});
        },
        closeRoomModal() {
            this.roomModalOpen = false;
        },
    },
    computed: {
        ...mapGetters([
            'getTags',
            "getActiveFilter",
            "getRooms",
            "getFilterQuery",
            "getRoomVideo",
            "getAllOnlineRooms",
        ]),
    },
    watch: {
        'getFilterQuery': function () {
            this.$router.push(`/tags/?page=1${this.getFilterQuery}`);
        },
        'getRooms': function () {
            this.rooms = this.getRooms;
        },
        'getRoomVideo': function () {
            this.roomVideo = this.getRoomVideo;
        },
        'getActiveFilter': function () {
            this.filter = this.getActiveFilter;
        },
        '$route.query': function () {
            this.setFilterWithQuery(new URLSearchParams(this.$route.query));
        }
    }
}
</script>

<style scoped>

</style>