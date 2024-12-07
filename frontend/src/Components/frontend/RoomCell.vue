<template>
    <div>

        <div
            :class="className"
            class="w-full aspect-4/3 bg-primary bg-cover bg-no-repeat rounded-md hover:scale-105 transition-all cursor-pointer overflow-hidden relative"
            :data-lg="room?.length"
            v-if="!room?._id"
        >
            <loading
                :active="!room?._id"
                :can-cancel="false"
                :is-full-page="false"
                loader="bars"
                background-color="#fff"
            />
        </div>

        <div
            v-else
            :class="className"
            class="w-full aspect-4/3 bg-primary bg-cover bg-no-repeat rounded-md hover:scale-105 transition-all cursor-pointer overflow-hidden relative"
            @click="openRoomVideo"
            :style="returnImage()"
        >
            <div class="absolute top-0 left-0">
                <img
                    src="/assets/images/new.png"
                    class="h-10 w-10 bg-cover bg-no-repeat"
                    alt="New room"
                    v-if="room?.new && !rank"
                />
                <img src="/assets/images/first.png" alt="First" v-if="rank === 1">
                <img src="/assets/images/second.png" alt="second" v-if="rank === 2">
                <img src="/assets/images/third.png" alt="third" v-if="rank === 3">
            </div>
            <button @click.stop="newWindow" class="text-white py-1 px-3 rounded-md text-lg absolute right-1">
                <font-awesome-icon :icon="['fas', 'window-restore']" />
            </button>

            <BottomInfoBar :room="room" v-show="thumbnail" v-if="room?._id" />
        </div>
    </div>
</template>

<script>
import BottomInfoBar from "@/components/frontend/BottomInfoBar.vue";
import {mapMutations, mapGetters} from "vuex";
import Loading from 'vue3-loading-overlay';
// Import stylesheet
import 'vue3-loading-overlay/dist/vue3-loading-overlay.css';

export default {
    name: "RoomCell",
    components: {BottomInfoBar, Loading},
    props: {
        room: {
            type: Object,
            default: {},
            required: false
        },
        rank: null|Number,
        className: null|String,
    },
    data() {
        return {
            thumbnail: true,
        }
    },
    created() {
        this.thumbnail = this.getActiveFilter.thumbnail;
    },
    computed: {
        ...mapGetters([
            "getActiveFilter",
        ]),
    },
    methods: {
        ...mapMutations([
            'setRoomVideo',
        ]),
        returnImage() {
            return `background-image: url(${this.room.preview_image});`
        },
        newWindow() {
            const date = new Date()
            const mSec = date.getTime()
            const myWindow = window.open(
                `/room-preview/${this.room.username}/${this.room.chat}/${this.room._id}`,
                'Popup' + mSec,
                'width=850,height=600'
            )
            myWindow?.focus()
        },
        openRoomVideo() {
            this.setRoomVideo(this.room);
            window.scrollTo(0,0);
        }
    },
    watch: {
        "getActiveFilter.thumbnail": function (val, oldVal) {
            this.thumbnail = this.getActiveFilter.thumbnail;
        }
    }
}
</script>

<style scoped>

</style>
