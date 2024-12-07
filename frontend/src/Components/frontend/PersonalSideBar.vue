<template>
    <div class="fixed top-28 md:top-[6rem] right-[5rem] z-[60] transition-all ease-in-out duration-700"
         :class="{'!right-96 mr-4 rotate-180': openSidebar}">
        <button
            type="button"
            class="rounded-md text-gray-300 hover:text-white !cursor-pointer"
            @click="setOpen"
        >
            <font-awesome-icon
                class="h-6 w-6 p-2 bg-primary rounded-full rotate-180"
                :icon="['fas', 'angles-right']"
            />
        </button>
    </div>

    <TransitionRoot :show="openSidebar" as="Fragment">
        <Dialog as="div" class="relative z-50" :onClose="setOpen">
            <TransitionChild
                as="Fragment"
                enter="ease-in-out duration-500"
                enterFrom="opacity-0"
                enterTo="opacity-100"
                leave="ease-in-out duration-500"
                leaveFrom="opacity-100"
                leaveTo="opacity-0"
            >
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"/>
            </TransitionChild>

            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                        <TransitionChild
                            as="Fragment"
                            enter="transform transition ease-in-out duration-500 sm:duration-700"
                            enterFrom="translate-x-full"
                            enterTo="translate-x-0"
                            leave="transform transition ease-in-out duration-500 sm:duration-700"
                            leaveFrom="translate-x-0"
                            leaveTo="translate-x-full"
                        >
                            <DialogPanel class="pointer-events-auto relative w-96 h-full">
                                <div
                                    class="flex h-full flex-col overflow-y-scroll bg-secondary-color text-white py-6 shadow-xl">
                                    <div class="px-4 sm:px-6">
                                        <DialogTitle class="text-lg font-medium">
                                            <span v-if="user?.name">
                                                You are
                                                <strong class="text-primary">
                                                {{ user.name }}
                                                </strong>
                                            </span>
                                            <span v-else>
                                                You are not logged in
                                                <router-link :to="{name: 'login'}" class="text-primary hover:underline">Log in here!</router-link>
                                            </span>
                                        </DialogTitle>
                                    </div>
                                    <div class="relative mt-6 flex-1 px-4 sm:px-6">
                                        <div v-if="user?.name">
                                            <PersonalSliderDisclosure
                                                :title="`Followed rooms (${followedRooms.length})`"
                                                :room-previews="followedRooms"
                                            >
                                                <button @click="openPopupWindowRooms('followed-rooms')"
                                                        class="underline text-white cursor-pointer">
                                                    show all
                                                </button>
                                            </PersonalSliderDisclosure>

                                            <PersonalSliderDisclosure
                                                :title="`Hidden rooms (${hiddenRooms.length})`"
                                                :roomPreviews="hiddenRooms"
                                            >
                                                <button @click="openPopupWindowRooms('hidden-rooms')"
                                                        class="underline text-white cursor-pointer">
                                                    show all
                                                </button>
                                            </PersonalSliderDisclosure>

                                            <PersonalSliderDisclosure
                                                :title="`Liked rooms (${likedRooms.length})`"
                                                :roomPreviews="likedRooms"
                                            >
                                                <button @click="openPopupWindowRooms('liked-rooms')"
                                                        class="underline text-white cursor-pointer">
                                                    show all
                                                </button>
                                            </PersonalSliderDisclosure>

                                            <PersonalSliderDisclosure
                                                :title="`Notes (${notes.length})`"
                                            >
                                                <button @click="openNotesModal()"
                                                        class="underline text-white cursor-pointer">
                                                    show all noteses
                                                </button>
                                            </PersonalSliderDisclosure>
                                        </div>
                                        <PersonalSliderDisclosure
                                            title="Trending rooms"
                                            :roomPreviews="getTrendingRooms"
                                            :showLikes="true"
                                            v-if="getTrendingRooms"
                                        >
                                        </PersonalSliderDisclosure>

                                        <PersonalSliderDisclosure
                                            title="Last visited rooms"
                                            :roomPreviews="getLastVisitedRooms"
                                        />
                                    </div>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import PersonalSideBarRoomItem from '@/components/frontend/personalSidebar/PersonalSideBarRoomItem.vue'
import PersonalSideBarTrendingRoomItem from '@/components/frontend/personalSidebar/PersonalSideBarTrendingRoomItem.vue'
import {DialogPanel, DialogTitle, TransitionChild, TransitionRoot, Dialog} from "@headlessui/vue";
import PersonalSliderDisclosure from "@/components/frontend/PersonalSliderDisclosure.vue";
import {mapGetters, mapActions, mapMutations} from "vuex";
import NotesModal from "@/components/frontend/modals/NotesModal.vue";

export default {
    name: "PersonalSideBar",
    components: {
        NotesModal,
        PersonalSliderDisclosure,
        DialogTitle,
        DialogPanel,
        TransitionChild,
        TransitionRoot,
        PersonalSideBarTrendingRoomItem,
        PersonalSideBarRoomItem,
        Dialog,
    },
    data() {
        return {
            expanded: false,
            user: {},
            openSidebar: false,
            followedRooms: [],
            hiddenRooms: [],
            likedRooms: [],
            notes: [],
        }
    },
    async created() {
        if (this.$cookies.get("my_token")) {
            if (!this.getUser?.name) {
                await this.fetchUser();
            }

            this.user = this.getUser;
            this.getHiddenRooms();
            this.getFollowedRooms();
            this.getLikedRooms();
            this.setUserNotes();
        }

        this.fetchTrendingRooms();
        this.fetchLastVisitedRooms();
    },
    methods: {
        ...mapActions([
            "fetchTrendingRooms",
            "fetchLastVisitedRooms"
        ]),
        ...mapActions('auth', ["fetchUser"]),
        ...mapMutations([
            "setOpenNotesModal",
        ]),
        setOpen() {
            this.openSidebar = !this.openSidebar;
        },
        getHiddenRooms() {
            this.hiddenRooms = this.user.hidden_rooms;
        },
        getFollowedRooms() {
            this.followedRooms = this.user.followed_rooms;
        },
        getLikedRooms() {
            this.likedRooms = this.user.liked_rooms;
        },
        setUserNotes() {
            this.notes = this.user.notes;
        },
        openPopupWindowRooms(url) {
            const date = new Date()
            const mSec = date.getTime()
            const myWindow = window.open(
                url,
                'Popup' + mSec,
                'width=850,height=600'
            )
            myWindow?.focus()
        },
        openNotesModal() {
            this.setOpenNotesModal(true);
        }
    },
    computed: {
        ...mapGetters("auth", [
            "getUser",
        ]),
        ...mapGetters([
            "getTrendingRooms",
            "getRooms",
            "getLastVisitedRooms",
        ]),

    },
    watch: {
        'getUser': function () {
            this.user = this.getUser;
            this.getHiddenRooms();
            this.getFollowedRooms();
            this.getLikedRooms();
            this.setUserNotes();
        },
        'openSidebar': function () {
            this.fetchLastVisitedRooms();
        }
    }
}
</script>
