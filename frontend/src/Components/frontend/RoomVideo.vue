<template>
    <div class="bg-secondary-color bg-blend-overlay rounded-md transition-all">
        <div>
            <div class="mt-5 border border-secondary-color">
                <header
                    class="flex items-center justify-between gap-5 px-10 py-2 relative bg-secondary-color rounded-t-md text-white text-lg font-bold">
                    <div class="flex gap-2">
                        <a
                            v-if="roomData"
                            :href="roomData.chat_url"
                            target="_blank"
                            class="block h-8 w-8 bg-center bg-contain bg-no-repeat"
                            :style="chatLogo"
                        ></a>
                        <span v-if="roomData"> {{ roomData.username }}</span>
                    </div>
                    <div class="flex gap-4">
                        <button
                            v-if="roomData"
                            type="button"
                            class="button-style"
                            @click="handleRoomPopUpSwitch"
                        >
                            menu
                        </button>
                        <a
                            v-if="roomData"
                            :href="`/profile/${roomData.username}/${roomData.chat}/${roomData._id}`"
                            class="button-style"
                            target="_blank"
                        >
                            profile
                        </a>
                        <button
                            v-if="roomData"
                            class="p-2 px-4 bg-bg-color rounded-md cursor-pointer"
                            :class="{'!bg-primary-color': false && likedRooms.includes(roomData._id)}"
                            @click="likeRoom"
                        >
                            <font-awesome-icon :icon="['fas', 'thumbs-up']"/>
                            {{ `(${roomData?.likes !== undefined ? roomData?.likes : 0})` }}
                        </button>
                        <button
                            v-if="roomData"
                            :class="[
                  'p-2 px-4 bg-bg-color rounded-md cursor-pointer',
                  followedRooms.includes(roomData._id) && '!bg-primary-color',
                ]"
                            @click="followRoom"
                        >
                            <font-awesome-icon :icon="['fas', 'heart']"/>
                            {{ `(${roomData?.followers !== undefined ? roomData?.followers : 0})` }}
                        </button>
                    </div>
                    <span>
              <font-awesome-icon
                  :icon="['fas', 'times']"
                  class="text-2xl cursor-pointer"
                  @click="closeVideo"
              />
            </span>
                </header>
                <main v-if="roomData" class="w-full text-white" ref="mainIframe">
                    <iframe
                        v-if="parseInt(roomData.chat) === 5"
                        :src="roomData.embed_url"
                        class="w-full aspect-video max-h-[70vh] h-full"
                        height=528 width=850
                        style='border: none;'
                        frameborder="0"></iframe>
                    <iframe
                        v-else-if="parseInt(roomData.chat) !== 1"
                        :src="roomData.chat_url"
                        class="w-full aspect-video max-h-[70vh] h-full"
                        :title="roomData.username"
                    ></iframe>
                    <iframe v-else-if="parseInt(roomData.chat) === 1" :src='`https://chaturbate.com/in/?tour=9oGW&amp;campaign=6N1LL&amp;track=embedMCS&amp;room=${roomData.username}&amp;bgcolor=white`' height=528 width=850 style='border: none;' class="w-full aspect-video max-h-[70vh] h-full"></iframe>
                </main>
                <div
                    class="flex flex-wrap items-center gap-10 px-10 py-2 bg-secondary-color rounded-b-md text-white"
                >
                    <button
                        v-if="roomData"
                        @click="redirectToUrl(roomData)"
                        type="button"
                        class="mx-auto text-white text-2xl font-bold uppercase text-center"
                    >
                        Chat with me
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapMutations,mapGetters, mapActions} from "vuex";
import api from "@/store/api";
import auth from "@/store/auth/auth"


export default {
    name: 'RoomVideo',
    data() {
        return {
            likedRooms: [],
            followedRooms: [],
            hiddenRooms: [],
            roomData: [],
            iframeReady: false,
        }
    },
    created() {
        this.roomData = this.getRoomVideo;
        this.setLastVisited();
    },
    computed: {
        ...mapGetters([
            "getRoomVideo"
        ]),
        chatLogo() {
            if (this.roomData) {
                return `background-image: url("/assets/chats/${this.roomData.chat}.png");`
            }
            return ''
        },
    },
    methods: {
        ...mapMutations([
            "setRoomModal",
            "setRoomVideo",
        ]),
        ...mapActions([
            "fetchLastVisitedRooms",
        ]),
        closeVideo() {
            this.setRoomVideo([]);
        },
        likeRoom() {
            if (this.$cookies.get("my_token")) {
                auth.post('api/liked-rooms', {
                    room_id: this.roomData._id,
                }).then(res => {
                    if (res.status === 201) {
                        this.roomData.likes++;
                        this.isLiked = true;
                    } else {
                        this.roomData.likes--;
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
                    room_id: this.roomData._id,
                }).then(res => {
                    if (res.status === 201) {
                        this.roomData.followers++;
                        this.isFollowed = true;
                    } else {
                        this.roomData.followers--;
                        this.isFollowed = false;
                    }
                });
            } else {
                this.$router.push({name: 'login'})
            }
        },
        handleRoomPopUpSwitch() {
            this.setRoomModal(this.roomData);
        },
        redirectToUrl(room) {
            window.open(room.chat_url, '_blank')
        },
        setLastVisited() {
            if (this.$cookies.get("my_token")) {
                auth.post('api/last-visited-rooms', {
                    identify: localStorage.getItem("localIdentify"),
                    room_id: this.roomData._id,
                }).then(res => {
                    this.fetchLastVisitedRooms();
                })
            } else {
                api.post('api/last-visited-rooms', {
                    identify: localStorage.getItem("localIdentify"),
                    room_id: this.roomData._id,
                }).then(res => {
                    this.fetchLastVisitedRooms();
                })
            }
        }
    },
    watch: {
        'getRoomVideo': function () {
            this.roomData = this.getRoomVideo;
            this.setLastVisited();
        }
    }
}
</script>

<style scoped lang="postcss">
.aspect-ratio {
    padding: 20%;
}

.button-style {
    @apply p-2 bg-bg-color rounded-md hover:bg-third-color;
}
</style>
