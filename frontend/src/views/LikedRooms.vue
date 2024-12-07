<template>
    <PersonalRoomLayout>
        <table
            class="w-full text-white text-left border-collapse border border-white bg-secondary-color"
        >
            <thead>
            <tr>
                <th class="border border-white">Status</th>
                <th class="border border-white">Username</th>
                <th class="border border-white">Links</th>
                <th class="border border-white">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="room in rooms" :key="room._id">
                <td class="border border-white">
                    <StatusIcon :status="getStatuses[0][room?.status]"/>
                </td>
                <td class="border border-white">
                    {{ room.username }}
                </td>
                <td class="border border-white">
                    <div class="flex items-center gap-4">
            <span
                class="block w-4 h-4 text-white text-center bg-third-color leading-4 rounded-full cursor-pointer"
                @click="handleRoomPopUpSwitch(room)"
            >
              M
            </span>
                        <a
                            :href="`/profile/${room.username}/${room.chat}/${room._id}`"
                            target="_blank"
                            class="block w-4 h-4 text-white text-center bg-third-color leading-4 rounded-full"
                        >
                            P
                        </a>
                    </div>
                </td>
                <td class="border border-white">
          <span
              class="text-red-500 hover:underline hover:cursor-pointer"
              @click="removeRoom(room)"
          >
            unlike
          </span>
                </td>
            </tr>
            </tbody>
        </table>
    </PersonalRoomLayout>
</template>

<script>
import {mapGetters, mapMutations, mapActions} from "vuex";
import StatusIcon from "@/components/partials/StatusIcon.vue";
import PersonalRoomLayout from "@/views/layouts/PersonalRoomLayout.vue";
import auth from '@/store/auth/auth';

export default {
    name: "HiddenRooms",
    data() {
        return {
            rooms: [],
        }
    },
    async created() {
        if (this.$cookies.get("my_token")) {
            if (!this.getUser?.name) {
                await this.fetchUser();
            }

            this.user = this.getUser;
            this.rooms = this.user.liked_rooms;
        }
    },
    methods: {
        ...mapMutations([
            'setRoomModal',
        ]),
        ...mapActions('auth', [
            'fetchUser',
        ]),
        removeRoom(room) {
            auth.post("api/liked-rooms", {
                room_id: room._id,
            }).then(res => {
                this.fetchUser();
            });
        },
        handleRoomPopUpSwitch(room) {
            this.setRoomModal(room);
        },
    },
    computed: {
        ...mapGetters("auth", [
            "getUser",
        ]),
        ...mapGetters([
            "getStatuses",
            "getChats",
        ]),
    },
    components: {
        PersonalRoomLayout,
        StatusIcon,
    },
    watch: {
        'getUser': function () {
            this.rooms = this.getUser.liked_rooms;
        }
    }
}
</script>

<style scoped>

</style>