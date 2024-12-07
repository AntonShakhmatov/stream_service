<template>
<!--    <title :html="`${room?.username} > ${room?.chat} model ❤️ MyCamStars`"></title>-->
    <MainLayout>
        <div class="min-h-screen flex gap-5 mt-5 flex-wrap-reverse xl:flex-nowrap">
            <InfoSection :room="room" :stats="roomStats" v-if="isLoading" />
            <section class="w-full flex flex-col">
                <h1 class="title">Live room</h1>
                <ProfileVideo :room="room" v-if="isLoading" />
<!--                <ProfilePhotoSection :photos="photos" v-if="isLoading" />-->
                <ProfileChart :room="room" :roomStats="roomStats" v-if="isLoading" />
            </section>
        </div>
    </MainLayout>
</template>

<script>
import MainLayout from "@/views/layouts/MainLayout.vue";
import InfoSection from "@/components/frontend/Profile/InfoSection.vue";
import ProfileVideo from "@/components/frontend/Profile/ProfileVideo.vue";
import ProfilePhotoSection from "@/components/frontend/Profile/ProfilePhotoSection.vue";
import ProfileChart from "@/components/frontend/Profile/ProfileChart.vue";
import {mapMutations,mapActions, mapGetters} from "vuex";

export default {
    name: "Profile",
    components: {
        ProfileChart,
        ProfilePhotoSection,
        ProfileVideo,
        InfoSection,
        MainLayout,
    },
    data() {
        return {
            room: [],
            photos: [],
            roomStats: [],
            isLoading: false,
        }
    },
    async created() {
        if (this.getProfileRoom.length === 0) {
            const roomId = this.$route.params.roomId;
            await this.fetchRoom(roomId);
            this.setProfileRoom(this.getRoom);
            this.room = this.getRoom;
            await this.fetchData();
        } else {
            this.fetchData()
        }
    },
    methods: {
        ...mapActions([
            "fetchProfileRoomStats",
            "fetchRoom",
            "fetchProfileRoomOnlineTimes",
        ]),
        ...mapMutations([
            "setProfileRoom",
        ]),
        async fetchData() {
            await this.fetchProfileRoomStats();
            this.roomStats = this.getProfileRoomStats;
            await this.fetchProfileRoomOnlineTimes();
            this.isLoading = true;
        }
    },
    computed: {
        ...mapGetters([
            'getProfileRoom',
            "getProfileRoomPhotos",
            "getProfileRoomStats",
            "getRooms",
            "getRoom",
        ])
    }
}
</script>

<style scoped>

</style>
