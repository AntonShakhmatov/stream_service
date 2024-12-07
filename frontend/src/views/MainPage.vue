<template>
    <MainLayout :filter="filter" :hidden-rooms="hiddenRooms">
        <RoomVideo v-if="roomVideo?._id" />
        <TopRated />
        <section class="mt-5 md:flex items-center justify-between">
            <div class="flex flex-wrap gap-2 my-3">
                <BaseButton @click="toggleSidebarFilter" :class="{'!bg-primary-color': sideFilterOpen}">
                    Filter
                </BaseButton>

                <p class="text-left text-white font-bold text-xl">
                    {{roomsCount}} rooms found
                </p>
            </div>

            <div class="flex gap-2 mt-3 md:mt-0">
                <refresh-button />

                <button class="px-3 py-[0.4rem] transition-all text-white text-sm rounded-md border border-white bg-primary-color hover:bg-secondary-color" @click="refresh">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="h-4 w-4">
                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                    </svg>
                </button>

                <MainFilter
                    @changeFilter="getFilteredData"
                />
            </div>

            <div class="flex gap-2 my-6 md:my-0">
                <BaseButton
                    :class="{'!bg-primary-color': getActiveFilter.showJustNewModels === true}"
                    class="w-1/2"
                    @click="changeFilterNew()"
                >
                    New
                </BaseButton>

                <TagsFilter @setSelectedTag="setSelectedTags" />
            </div>

            <pagination v-if="rooms" :rooms="rooms" />

            <GridResize class="my-5 md:my-0" :value="gridSize" @input="setGridSize"/>
        </section>

        <ActiveFilters :filter="filter" @resetFilter="resetFilter" />
        <section class="md:flex gap-5 mt-5 relative">
            <MainFeedSideFilter :open="sideFilterOpen" @closeFilter="toggleSidebarFilter" />

            <EmptyRooms className="w-full m-auto" v-if="rooms.data?.length === 0"/>

            <rooms-resizable-grid :rooms="rooms?.data" :grid-size="gridSize" />
        </section>

        <pagination v-if="rooms.data?.length" :rooms="rooms" class="flex items-center justify-end mt-10" />


    </MainLayout>
</template>

<script>
import MainLayout from "@/views/layouts/MainLayout.vue";
import TopRated from "@/components/frontend/TopRated.vue";
import BaseButton from "@/components/partials/BaseButton.vue";
import MainFilter from "@/components/frontend/MainFilter.vue";
import GridResize from "@/components/frontend/GridResize.vue";
import TagsFilter from "@/components/frontend/TagsFilter.vue";
import ActiveFilters from "@/components/frontend/ActiveFilters.vue";
import MainFeedSideFilter from "@/components/frontend/MainFeedSideFilter.vue";
import EmptyRooms from "@/components/frontend/EmptyRooms.vue";
import RoomsResizableGrid from "@/components/frontend/RoomsResizableGrid.vue";
import RoomVideo from "@/components/frontend/RoomVideo.vue";
import Pagination from "@/components/frontend/Pagination.vue";
import {isBoolean} from "lodash";
import {mapGetters, mapActions, mapMutations} from 'vuex'
import {Popover, PopoverButton, PopoverPanel} from "@headlessui/vue";
import RefreshButton from "@/components/frontend/RefreshButton.vue";
import { uuid } from 'vue-uuid';
import Loading from 'vue3-loading-overlay';
// Import stylesheet
import 'vue3-loading-overlay/dist/vue3-loading-overlay.css';

export default {
    name: "MainPage",
    components: {
        RefreshButton,
        PopoverPanel,
        PopoverButton,
        Popover,
        RoomVideo,
        RoomsResizableGrid,
        EmptyRooms,
        MainFeedSideFilter,
        TagsFilter, GridResize, MainFilter, BaseButton, TopRated, MainLayout, ActiveFilters,Pagination, Loading},
    data() {
        return {
            sideFilterOpen: false,
            gridSize: 2,
            roomVideo: [],
            total: 0,
            roomsCount: 0,
            rooms: [],
            filter: [],
            hiddenRooms: [],
            page: 0,
            isDropdownOpen: false,
            selectedRefresh: 120000,
            timer: "",
        }
    },
    async created() {
        this.page = this.$route.query?.page ? this.$route.query?.page : 1;
        this.setActiveFilter();
        await this.fetchRoomData();
        this.timer = setInterval(this.fetchRoomData, 120000);
        this.filter = this.getFilter;
        this.sideFilterOpen = this.getSidebarFilter;

        if (!isBoolean(this.filter.showJustNewModels)) {
            this.filter.showJustNewModels = this.filter.showJustNewModels === "true"
        }
        if (!isBoolean(this.filter.showJustHDRooms)) {
            this.filter.showJustHDRooms = this.filter.showJustHDRooms === "true"
        }
        if (!localStorage.getItem('localIdentify')) {
            localStorage.setItem('localIdentify', uuid.v4())
        }
    },
    methods: {
        ...mapMutations([
            'setSidebarFilter',
            "setFilterWithQuery"
        ]),
        ...mapActions([
            'fetchRooms',
        ]),
        setGridSize(val) {
            this.gridSize = val;
        },
        setSelectedTags() {
            this.getFilteredData();
        },
        resetFilter() {
            this.getFilteredData();
        },
        changeFilterNew() {
            this.getActiveFilter.showJustNewModels = !this.getActiveFilter.showJustNewModels;
            this.getFilteredData();
        },
        getFilteredData() {
            this.fetchRooms({page: this.page, filter: this.getActiveFilter});
        },
        setRoomVideo(val) {
            this.roomVideo = val;
        },
        closeRoomVideo() {
            this.roomVideo = {};
        },
        refresh() {
            this.fetchRooms({page: this.page, filter: this.getActiveFilter});
        },
        toggleSidebarFilter() {
            this.sideFilterOpen = !this.sideFilterOpen;
        },
        setActiveFilter() {
            this.setFilterWithQuery(new URLSearchParams(this.$route.query));
        },
        async fetchRoomData() {
            await this.fetchRooms({page: this.page, filter: this.getActiveFilter});
            this.rooms = this.getRooms;
            this.roomsCount = this.getRooms.total;
        },
        cancelAutoUpdate() {
            clearInterval(this.timer);
        },
    },
    computed: {
        ...mapGetters([
            'getRooms',
            'getTopRatedRooms',
            "getFilter",
            "getSidebarFilter",
            'getRoomVideo',
            "getActiveFilter",
            "getFilterQuery",
        ])
    },
    watch: {
        'this.filter': function (old, val) {
            router.get("/", this.filter, {
                preserveState: true,
                preserveScroll: true,
            });
        },
        'getRooms': function () {
            this.rooms = this.getRooms;
            this.roomsCount = this.getRooms.total;
        },
        'getRoomVideo': function () {
            this.roomVideo = this.getRoomVideo;
        },
        'getActiveFilter': function () {
        },
        'getFilterQuery': function () {
            this.$router.push(`/?page=1${this.getFilterQuery}`);
        }
    },
    beforeUnmount() {
        this.cancelAutoUpdate();
    },
}
</script>

<style scoped>
.dropdown {
    position: relative;
}

.dropdown-toggle {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.5rem 1rem;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 4px;
    cursor: pointer;
}

.dropdown-icon {
    width: 1rem;
    height: 1rem;
    margin-left: 0.5rem;
    transition: transform 0.2s;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 10;
    display: none;
    margin-top: 0.5rem;
    padding: 0.5rem 0;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 4px;
    list-style: none;
    cursor: pointer;
}

.dropdown-menu li {
    padding: 0.5rem 1rem;
}

.dropdown-menu li:hover {
    background-color: #f5f5f5;
}
</style>
