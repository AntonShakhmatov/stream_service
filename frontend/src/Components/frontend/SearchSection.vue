<template>
        <div class="flex flex-col gap-4" v-if="isLoading">
            <div class="flex items-center gap-4">
                <h1 class="title">
                    {{ label }} | {{ listedCount() }} of {{ rooms?.total ? rooms.total : 0 }} listed
                </h1>
            </div>
            <div class="w-full">
            </div>
            <div>
                <RoomsResizableGrid :rooms="rooms.data" v-if="rooms?.data?.length" :grid-size="2" />

                <LinePagination :rooms="rooms" :page="page" v-if="rooms?.data?.length" />

                <span class="block w-full text-white text-center" v-if="rooms?.data?.length === 0">
                    No data for this category
                </span>
            </div>
        </div>
</template>

<script>
import Pagination from "@/components/frontend/Pagination.vue";
import RoomsResizableGrid from "@/components/frontend/RoomsResizableGrid.vue";
import LinePagination from "./LinePagination.vue";

export default {
    name: "SearchSection",
    components: {LinePagination, RoomsResizableGrid, Pagination},
    props: {
        label: String,
        rooms: Object,
        page: String,
    },
    data() {
        return {
            isLoading: true,
        }
    },
    created() {
        if (this.rooms?.data?.length) {
            this.isLoading = false;
        }
    },
    methods: {
        listedCount() {
            if (this.rooms?.data?.length) {
                return this.rooms?.data?.length * this.rooms?.current_page
            } else {
                return 0;
            }
        }
    }
}
</script>

<style scoped>

</style>
