<template>
    <div>
        <div class='bg-secondary-color rounded-md text-white text-lg mt-5'>
            <header class="flex items-center justify-between gap-5 px-10 py-2 relative font-bold">
                <div class="flex gap-2">
                    <a
                        :href="room?.chat_url"
                        target="_blank"
                        :title="room?.chat"
                        class="block h-8 w-8 bg-center bg-contain bg-no-repeat"
                        :style="chatImageUrl()"
                    ></a>
                    <span>{{ room?.username }}</span>
                </div>
                <div class="flex gap-4">
                    <button
                        @click="likeRoom"
                        class="p-2 px-4 bg-bg-color rounded-md cursor-pointer"
                        :class="{'!bg-primary-color': room?.likes !== 0}"
                    >
                        <font-awesome-icon :icon="['fas', 'thumbs-up']" />
                        {{ room?.likes }}
                    </button>
                    <button
                        @click="followRoom"
                        class='p-2 px-4 bg-bg-color rounded-md cursor-pointer'
                        :class="{'!bg-primary-color': room?.followers !== 0}"
                    >
                        <font-awesome-icon :icon="['fas', 'heart']" />
                        {{ room?.followers }}
                    </button>
                </div>
            </header>
            <main>
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
                <iframe v-else :src='`https://chaturbate.com/in/?tour=9oGW&amp;campaign=6N1LL&amp;track=embedMCS&amp;room=${room.username}&amp;bgcolor=white`' height=550 width=850 style='border: none;' class="w-full aspect-video max-h-[76vh] h-full"></iframe>
            </main>
            <div class="flex flex-wrap items-center gap-10 px-10 py-2 bg-secondary-color rounded-b-md text-white">
                <button
                    v-if="room"
                    @click="redirectToUrl(room)"
                    type="button"
                    class="mx-auto text-white text-2xl font-bold uppercase text-center"
                >
                    Chat with me
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import auth from '@/store/auth/auth';
import {mapGetters,mapActions} from "vuex";

export default {
    name: "ProfileVideo",
    data() {
        return {
            isLiked: false,
            isFollowed: false,
        }
    },
    props: {
        room: Object,
    },
    methods: {
        chatImageUrl() {
            return `background-image: url('/assets/chats/${this.getChats[0][this.room.chat]}.png')`;
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
        redirectToUrl(room) {
            window.open(room.chat_url, '_blank')
        },
    },
    computed: {
        ...mapGetters([
            'getStatuses',
            "getChats",
        ]),
    }
}
</script>

<style scoped>

</style>
