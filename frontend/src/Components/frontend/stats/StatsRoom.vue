<template>
    <div
        :class="className"
        class="w-full aspect-4/3 bg-primary bg-cover bg-no-repeat rounded-md hover:scale-105 transition-all cursor-pointer overflow-hidden relative"
        @click="openRoomVideo"
        :style="returnImage()"
        v-show="!loading"
    >
        <div class="absolute top-0 left-0">
            <img
                src="../../../assets/images/new.png"
                class="h-10 w-10 bg-cover bg-no-repeat"
                alt="New room"
                v-if="room.new && !rank"
            />
            <img src="../../../assets/images/first.png" alt="First" v-if="rank === 1">
            <img src="../../../assets/images/second.png" alt="second" v-if="rank === 2">
            <img src="../../../assets/images/third.png" alt="third" v-if="rank === 3">
        </div>
        <a
            @click="newWindow"
            class="h-10 w-10 inline-flex justify-center items-center absolute -top-1 -right-2 bg-background-primary rounded-full transform transition-all hover:bg-background-secondary hover:scale-125 opacity-50 hover:opacity-100"
        >
            <font-awesome-icon :icon="['fas', 'window-restore']" class="text-white"/>
        </a>

        <BottomInfoBar :room="room" v-show="thumbnail" />
    </div>
</template>

<script>
import BottomInfoBar from "@/components/frontend/BottomInfoBar.vue";
import {mapMutations, mapGetters} from "vuex";
import LoadingSkeleton from "@/views/LoadingSkeleton.vue";

export default {
    name: "StatsRoom",
    components: {BottomInfoBar, LoadingSkeleton},
    props: {
        room: Object,
        rank: null|Number,
        className: null|String,
    },
    data() {
        return {
            thumbnail: true,
            loading: true,
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
            this.loading = false;
            return `background-image: url(${this.room.preview_image});`
        },
        newWindow() {
            const date = new Date()
            const mSec = date.getTime()
            const myWindow = window.open(
                this.room.chat_url,
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