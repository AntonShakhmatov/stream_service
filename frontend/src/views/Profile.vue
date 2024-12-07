<template>
    <MainLayout>
        <div class="min-h-screen flex flex-col gap-5 mt-5 xl:flex-row">
            <InfoSection :room="room" :stats="roomStats" v-if="isLoading" />
            <!-- Bio (25%) -->
            <div class="bio-section w-full xl:w-1/4 p-5 bg-secondary-color rounded-md text-white">
                <h1 class="text-xl font-bold mb-3">{{ room.username }}</h1>
                <p class="mb-2"><strong>Age:</strong> {{ room.age }}</p>
                <p class="mb-2"><strong>Gender:</strong> {{ room.gender }}</p>
                <p class="mb-2"><strong>Ethnicity:</strong> {{ room.flag }}</p>
                <p class="mb-2"><strong>Viewers:</strong> {{ room.viewers }}</p>
                <p class="mb-2"><strong>Subject:</strong> {{ room.subject }}</p>
            </div>

            <!-- Video (75%) -->
            <div class="video-section w-full xl:w-3/4 p-5 bg-secondary-color rounded-md">
                <ProfileVideo v-if="room && room.chat_url" :room="room" />
            </div>
        </div>
    </MainLayout>
</template>

<script>
import MainLayout from "@/views/layouts/MainLayout.vue";
import InfoSection from "@/components/frontend/Profile/InfoSection.vue";
import ProfileVideo from "@/components/frontend/Profile/ProfileVideo.vue";
import ProfilePhotoSection from "@/components/frontend/Profile/ProfilePhotoSection.vue";
import ProfileChart from "@/components/frontend/Profile/ProfileChart.vue";
import PageContent from "@/components/PageContent.vue";
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
