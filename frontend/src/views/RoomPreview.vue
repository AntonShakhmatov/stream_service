<template>
    <PersonalRoomLayout>
        <header
            class="flex items-center gap-5 px-10 py-2 relative bg-secondary-color rounded-t-md text-white text-lg font-bold">
            <div class="flex gap-2">
                <a
                    v-if="room"
                    :href="room.chat_url"
                    target="_blank"
                    class="block h-8 w-8 bg-center bg-contain bg-no-repeat"
                ><img :src="chatLogo" alt=""></a>
                <span v-if="room"> {{ room.username }}</span>
            </div>
            <div class="flex gap-4 w-full justify-center items-center">
                <button
                    v-if="room"
                    type="button"
                    class="button-style"
                    @click="handleRoomPopUpSwitch"
                >
                    menu
                </button>
                <a
                    v-if="room"
                    :href="`/profile/${room.username}/${room.chat}/${room._id}`"
                    class="button-style"
                    target="_blank"
                >
                    profile
                </a>
                <button
                    v-if="room"
                    class="p-2 px-4 bg-bg-color rounded-md cursor-pointer"
                    :class="{'!bg-primary-color': false && likedRooms.includes(room._id)}"
                    @click="likeRoom"
                >
                    <font-awesome-icon :icon="['fas', 'thumbs-up']"/>
                    {{ `(${room.likes !== undefined ? room.likes : 0})` }}
                </button>
                <button
                    v-if="room"
                    :class="[
                  'p-2 px-4 bg-bg-color rounded-md cursor-pointer',
                  followedRooms.includes(room._id) && '!bg-primary-color',
                ]"
                    @click="followRoom"
                >
                    <font-awesome-icon :icon="['fas', 'heart']"/>
                    {{ `(${room.followers !== undefined ? room.followers : 0})` }}
                </button>
            </div>
        </header>
            <iframe
                v-if="parseInt(room.chat) === 5"
                :src="room.embed_url"
                class="w-full aspect-video max-h-[70vh] h-full"
                height=528 width=850
                style='border: none;'
                frameborder="0" />
            <iframe
                v-if="parseInt(room.chat) !== 1"
                :src="room.chat_url"
                class="w-full aspect-video max-h-[76vh] h-full"
                :title="room.username"
            >{{ room.chat }}</iframe>
            <iframe v-else class="w-full aspect-video max-h-[76vh] h-full" :src='`https:\\/\\/chaturbate.com\\/in\\/?tour=Jrvi&amp;campaign=6N1LL&amp;track=embed&amp;room=${room.username}&amp;bgcolor=white`'></iframe>
        <div
            class="flex flex-wrap items-center gap-10 px-10 py-2 bg-secondary-color rounded-b-md text-white"
        >
            <button
                v-if="room"
                @click="redirectToUrl(room)"
                type="button"
                class="mx-auto text-white text-2xl font-bold uppercase text-center"
            >
                Chat with me
            </button>
        </div>
    </PersonalRoomLayout>
</template>

<script>
import PersonalRoomLayout from "@/views/layouts/PersonalRoomLayout.vue";
import {mapGetters, mapActions, mapMutations} from "vuex";
import api from "@/store/api";

export default {
    name: "RoomPreview",
    components: {
        PersonalRoomLayout,
    },
    data() {
        return {
            room: [],
            likedRooms: [],
            followedRooms: [],
            hiddenRooms: [],
        }
    },
    async created() {
        await this.fetchRoom(this.$route.params.roomId);
        this.room = this.getRoom;
        this.setLastVisited();
    },
    methods: {
        ...mapActions([
            "fetchRoom",
            "fetchLastVisitedRooms",
        ]),
        ...mapMutations([
            "setRoomModal",
        ]),
        closeVideo() {
            this.setRoomVideo([]);
        },
        likeRoom() {
            if (this.$cookies.get("my_token")) {
                auth.post('api/liked-rooms', {
                    room_id: this.room._id,
                }).then(res => {
                    if (res.status === 201) {
                        this.room.likes++;
                        this.isLiked = true;
                    } else {
                        this.room.likes--;
                        this.isLiked = false;
                    }
                });
            } else {
                this.$router.push({name: 'login'})
            }
        },
        followRoom() {
            if (this.$cookies.get("my_token")) {
                auth.post("api/saved-rooms", {
                    room_id: this.room._id,
                }).then(res => {
                    if (res.status === 201) {
                        this.room.followers++;
                        this.isFollowed = true;
                    } else {
                        this.room.followers--;
                        this.isFollowed = false;
                    }
                });
            } else {
                this.$router.push({name: 'login'})
            }
        },
        handleRoomPopUpSwitch() {
            this.setRoomModal(this.room);
        },
        redirectToUrl(room) {
            window.open(room.chat_url, '_blank');
        },
        setLastVisited() {
            if (this.$cookies.get("my_token")) {
                auth.post('api/last-visited-rooms', {
                    identify: localStorage.getItem("localIdentify"),
                    room_id: this.room._id,
                }).then(res => {
                    this.fetchLastVisitedRooms();
                })
            } else {
                api.post('api/last-visited-rooms', {
                    identify: localStorage.getItem("localIdentify"),
                    room_id: this.room._id,
                }).then(res => {
                    this.fetchLastVisitedRooms();
                })
            }
        }
    },
    computed: {
        ...mapGetters([
            'getRoom',
        ]),
        chatLogo() {
            if (this.room) {
                return `/assets/chats/${this.room.chat}.png`
            }
            return ''
        },
    }
}
</script>

