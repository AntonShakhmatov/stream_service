<template>
    <div class="flex-grow max-w-full h-[min-content] grid gap-3 grid-rows-max-content roomResizableGrid"
         :class="gridSizeClass()"
    >
        <RoomCell
            v-for="key in 16"
            :key="key"
            v-if="!rooms?.length"
        />
        <RoomCell
            v-else
            v-for="room in rooms"
            :key="room._id"
            :room="room"
            @click="onRoomCellClick(room)"
        />
    </div>
</template>

<script>
import RoomCell from "@/components/frontend/RoomCell.vue";
import {mapMutations} from "vuex";

export default {
    name: "RoomsResizableGrid",
    components: {RoomCell},
    props: {
        rooms: Object,
        gridSize: Number,
    },
    methods: {
        ...mapMutations([
            "setRoomVideo",
        ]),
        gridSizeClass() {
            switch (this.gridSize) {
                case 1:
                    return "grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6";
                case 2:
                    return "grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-8";
                case 3:
                    return "xl:grid-cols-6 2xl:grid-cols-10";
                default:
                    return "xl:grid-cols-7 2xl:grid-cols-10";
            }
        },
        onRoomCellClick(room) {
            this.setRoomVideo(room);
        },
        openRoomVideo(room) {
            this.setRoomVideo(room);
        }
    }
}
</script>

<style scoped>

</style>
