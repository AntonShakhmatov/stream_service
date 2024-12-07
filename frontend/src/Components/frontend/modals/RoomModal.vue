<template>
    <TransitionRoot :show="open" as="Fragment">
        <Dialog as="div" class="relative z-50" onClose="onClose">
            <TransitionChild
                as="Fragment"
                enter="ease-out duration-300"
                enterFrom="opacity-0"
                enterTo="opacity-100"
                leave="ease-in duration-200"
                leaveFrom="opacity-100"
                leaveTo="opacity-0"
            >
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"/>
            </TransitionChild>

            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
                    <TransitionChild
                        as="Fragment"
                        enter="ease-out duration-300"
                        enterFrom="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enterTo="opacity-100 translate-y-0 sm:scale-100"
                        leave="ease-in duration-200"
                        leaveFrom="opacity-100 translate-y-0 sm:scale-100"
                        leaveTo="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <DialogPanel
                            class="relative bg-secondary-color rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 w-[350px] sm:p-6">
                            <div class="text-white">
                                <button
                                    @click="onClose"
                                    class="block w-max px-2 ml-auto text-white text-3xl"
                                >
                                    <font-awesome-icon :icon="['fas', 'times']"/>
                                </button>
                                <header class="flex flex-col gap-2 section">
<!--                                    <div class="grid grid-cols-2 gap-2">-->
<!--                                        <img-->
<!--                                            v-for="(photo, idx) in photos"-->
<!--                                            :key="idx"-->
<!--                                            :src="photo.url"-->
<!--                                            class="h-24 w-full bg-red-200 rounded-md"-->
<!--                                            :alt="Photos"-->
<!--                                        />-->
<!--                                    </div>-->
                                    <div class="flex flex-grow items-center justify-between gap-2">
                                        <div class="flex items-center">
                                            <div class="inline-flex mr-2">
                                                <a
                                                    :href="room.chatUrl"
                                                    target="_blank"
                                                    :title="room.chat"
                                                    class="h-4 w-4 bg-contain bg-no-repeat flex"
                                                    :style="chatLogo()"
                                                ></a>
                                            </div>
                                            <StatusIcon :status="getStatuses[0][room?.status]" class="mr-2"/>
                                            <div class="text-xl text-primary-color font-bold">
                                                {{ room?.username }}
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                        <span class="text-white">
                                          {{ room?.age || '-' }}
                                        </span>
                                            <font-awesome-icon :icon="['fas', genderIcon()]" v-if="room?.gender"/>
                                            <object
                                                :data="locationImageUrl()"
                                                type="image/png"
                                                class="h-3 w-3 !bg-cover !bg-no-repeat"
                                            >
                                                <img
                                                    src="@/assets/flags/unspecified-country.png"
                                                    class="h-3 w-3 !bg-cover !bg-no-repeat"
                                                    :title="room?.location"
                                                    :alt="room?.location"
                                                />
                                            </object>
                                            <a
                                                :href="room?.chat_url"
                                                target="_blank"
                                                :title="getChats[0][room?.chat]"
                                                class="h-4 w-4 bg-contain bg-no-repeat"
                                                :style="`background-image: url('${room?._id}')`"
                                            ></a>
                                        </div>
                                    </div>
                                </header>
                                <section class="p-1 border-b border-primary text-white">
                                    <p class="text-[#b3b3b3]">{{ room?.subject }}</p>
                                </section>
                                <section class="p-1 border-b border-primary text-white">
                                    <h1 class="text-primary-color text-lg font-bold uppercase">
                                        Stats
                                    </h1>
                                    <div class="grid grid-cols-2 gap-1 mt-1">
                                        <span>First seen</span>
                                        <span>
                                              {{ formatDate(room?.first_seen) || '-' }}
                                        </span>
                                        <span>Last seen</span>
                                        <span>
                                              {{ formatDate(room?.last_seen) || '-' }}
                                        </span>
                                        <span>Avg. Room ppl</span>
                                        <span>
                                              {{ room?.avg_viewers || '-' }}
                                        </span>
                                        <span>Most Room ppl</span>
                                        <span>
                                              {{ room?.max_viewers || '-' }}
                                        </span>
                                        <span v-if="room?.chat === 1">CB Followers</span>
                                        <span v-if="room?.chat === 1">
                                              {{ room?.cb_followers || '-' }}
                                        </span>

                                        <span v-if="room?.chat === 2">MFC camscore</span>
                                        <span v-if="room?.chat === 2">
                                              {{ room?.mfc_score ? parseFloat(room?.mfc_score).toFixed(1) : '-' }}
                                        </span>
                                        <span v-if="room?.chat === 2">Miss MFC </span>
                                        <span v-if="room?.chat === 2">
                                              {{ room?.mfc_rank || '-' }}
                                        </span>
                                    </div>
                                </section>
                                <section class="p-1 border-b border-primary text-white">
                                    <div class="grid grid-cols-2 gap-1 mt-1">
                                        <button
                                            @click="likeRoom"
                                            class="text-left hover:cursor-pointer hover:underline"
                                        >
                                            {{ isLiked ? 'Unlike' : 'Like' }} {{ room?.likes }}
                                        </button>
                                        <button
                                            @click="notesModal"
                                            class="text-left hover:cursor-pointer hover:underline">
                                            {{ isNotes ? "Edit Notes" : "Add notes" }}
                                        </button>
                                        <button
                                            @click="followRoom"
                                            class="text-left hover:cursor-pointer hover:underline"
                                        >
                                            {{ isFollowed ? 'Unfollow' : 'Follow' }}
                                        </button>
                                        <button
                                            @click="hideRoom"
                                            class="text-left hover:cursor-pointer hover:underline"
                                        >
                                            {{ isHidden ? 'Show' : 'Hide' }}
                                        </button>
                                    </div>
                                </section>
                                <footer class="mt-1 section flex items-center justify-evenly">
                                    <button
                                        @click.stop="openNewWindow"
                                        class="text-white py-1 px-3 bg-primary rounded-md cursor-pointer"
                                    >
                                        <font-awesome-icon :icon="['fas', 'window-restore']"/>
                                    </button>
                                    <a
                                        :href="`/profile/${room?.username}/${room?.chat}/${room?._id}`"
                                        target="_blank"
                                        class="text-white py-1 px-3 bg-primary rounded-md"
                                    >
                                        P
                                    </a>
                                    <a
                                        :href="room?.chat_url"
                                        target="_blank"
                                        class="text-white py-1 px-3 bg-primary rounded-md"
                                    >
                                        <font-awesome-icon :icon="['fas', 'link']"/>
                                    </a>
                                </footer>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import {Dialog, DialogPanel, TransitionChild, TransitionRoot} from "@headlessui/vue";
import StatusIcon from "@/components/partials/StatusIcon.vue";
import {mapGetters, mapMutations, mapActions} from "vuex";
import auth from '@/store/auth/auth';
import dayjs from "dayjs";

export default {
    name: "RoomModal",
    components: {StatusIcon, DialogPanel, TransitionChild, Dialog, TransitionRoot, dayjs},
    data() {
        return {
            open: false,
            room: [],
            isHidden: false,
            isFollowed: false,
            isLiked: false,
            photos: [],
            user: [],
            isNotes: false,
        }
    },
    async created() {
        await this.fetchUser();
        this.user = this.getUser;

        this.setIsLikedRooms(this.user);
        this.setIsFollowedRooms(this.user);
        this.setIsHiddenRooms(this.user);
        this.setIsNotes(this.user);
    },
    methods: {
        ...mapActions('auth', [
            "fetchUser"
        ]),
        ...mapMutations([
            "setRoomModal",
            "setNotesModal",
            "setOpenNotesModal",
        ]),
        genderIcon() {
            switch (this.room.gender) {
                case "m":
                case "male":
                    return "mars";
                case "f":
                case "female":
                    return "venus";
                case "c":
                case "couple":
                    return "venus-mars";
                case "t":
                case "trans":
                case "transgender":
                    return "transgender";
                default:
                    return "venus";
            }
        },
        locationImageUrl() {
            const normalizedLocation = this.room?.location?.toLowerCase().replaceAll(' ', '-')
            return `/flags/${normalizedLocation}.png`
        },
        chatLogo() {
            return `background-image: url('/assets/chats/${this.room?.chat}.png')`;
        },
        openNewWindow() {
            const date = new Date()
            const mSec = date.getTime()
            const myWindow = window.open(
                `/room-preview/${this.room.username}/${this.room.chat}/${this.room._id}`,
                'Popup' + mSec,
                'width=850,height=600'
            )
            myWindow?.focus();
        },
        onClose() {
            this.setRoomModal([]);
            this.isLiked = false;
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
                    this.fetchUser();
                });
            } else {
                this.$router.push({name: 'login'})
            }
        },
        hideRoom() {
            if (this.$cookies.get("my_token")) {
                auth.post("api/hidden-rooms", {
                    room_id: this.room._id,
                }).then(res => {
                    this.isHidden = res.status === 201;
                })
            } else {
                this.$router.push({name: 'login'});
            }
        },
        formatDate(date) {
            return dayjs(date).format("DD.MM.YYYY");
        },
        resetData() {
            this.isFollowed = false;
            this.isLiked = false;
            this.isHidden = false;
            this.isNotes = false;
        },
        setIsLikedRooms(user) {
            user?.liked_rooms?.forEach(liked => {
                if (liked.room_id === this.room._id) {
                    this.isLiked = true;
                }
            });
        },
        setIsFollowedRooms(user) {
            user?.followed_rooms?.forEach(room => {
                if (room._id === this.room._id) {
                    this.isFollowed = true;
                }
            });
        },
        setIsHiddenRooms(user) {
            user?.hidden_rooms?.forEach(room => {
                if (room._id === this.room._id) {
                    this.isHidden = true;
                }
            });
        },
        setIsNotes(user) {
            this.notes = user?.notes;

            this.notes?.forEach(note => {
                if (note.room._id === this.room?._id) {
                    this.isNotes = true;
                }
            })
        },
        notesModal() {
            if (this.$cookies.get("my_token")) {

                if (!this.isNotes) {
                    auth.post("api/room-notes", {
                        room_id: this.room._id,
                    }).then(res => {
                        this.isNotes = true;
                        this.setNotesModal(this.room);
                        this.setOpenNotesModal(true);
                    })
                } else {
                    this.setNotesModal(this.room);
                    this.setOpenNotesModal(true);
                }
            } else {
                this.$router.push({name: 'login'});
            }
        },
    },
    computed: {
        ...mapGetters([
            "getRoomModal",
            "getNotesModal",
            "getOpenNotesModal",
            "getStatuses",
            "getChats"
        ]),
        ...mapGetters('auth', [
            'getUser',
        ])
    },
    watch: {
        'getRoomModal': function () {
            this.resetData();
            this.room = this.getRoomModal;
            this.open = !this.open;

            this.setIsLikedRooms(this.user);
            this.setIsFollowedRooms(this.user);
            this.setIsHiddenRooms(this.user);
            this.setIsNotes(this.user);
        }
    }
}
</script>

<style scoped>

</style>
