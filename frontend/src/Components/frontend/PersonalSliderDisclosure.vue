<template>
    <Disclosure>
        <DisclosureButton class="inline-flex justify-between items-center w-full py-2 font-bold " @click="setIsOpenDisclosure">
            <span class="pl-3">{{title}}</span>
            <div class="inline-flex gap-4 items-center">
                <slot></slot>
                <font-awesome-icon
                    :icon="['fas', 'chevron-down']"
                    class="text-white text-xl cursor-pointer transition-all transform"
                    :classs="{'rotate-180': openDisclosure}"
                />
            </div>
        </DisclosureButton>
        <DisclosurePanel class="text-gray-500 max-h-[20%] overflow-hidden overflow-y-scroll">
            <div class="flex items-center gap-2 my-2 text-white text-sm pl-3 flex-wrap" v-for="roomPreview in roomPreviews" :key="roomPreview?._id">
                <div class="flex w-full gap-2">
                    <StatusIcon :status="getStatuses[0][roomPreview?.status]" />
                    <img
                        :src="`/assets/chats/${getChats[0][roomPreview.chat]}.png`"
                        class="w-5 h-5 bg-contain bg-no-repeat bg-chaturbate bg-center"
                        :alt="getChats[0][roomPreview.chat]"
                    />
                    <span class="overflow-hidden overflow-ellipsis text-[12px] w-[60%]">
                        {{ roomPreview.username }}
                    </span>
                    <div class="flex w-full" v-if="!showLikes">
                        <button
                            @click.stop="handleRoomPopUpSwitch(roomPreview)"
                            class="block w-4 h-4 ml-auto text-white text-center bg-background-primary leading-4 rounded-full mr-3"
                            title="Menu"
                        >
                            M
                        </button>
                        <a
                            :href="`/profile/${roomPreview.username}/${roomPreview.chat}/${roomPreview._id}`"
                            target="_blank"
                            class="block w-4 h-4 text-white text-center bg-background-primary leading-4 rounded-full pr-4"
                            title="Profile"
                        >
                            P
                        </a>
                    </div>
                </div>
                <div class="flex w-full justify-between items-center gap-2 text-white" v-if="showLikes">
                    <font-awesome-icon :icon="['fass', 'chart-line']" icon="" />
                    <span> + {{ roomPreview.view_diff }} </span>
                    <span> / {{ roomPreview.viewers }}</span>
                    <button
                        @click.stop="handleRoomPopUpSwitch(roomPreview)"
                        class="block w-4 h-4 ml-auto text-white text-center bg-background-primary leading-4 rounded-full"
                        title="Menu"
                    >
                        M
                    </button>
                    <a
                        :href="`/profile/${roomPreview.username}/${roomPreview.chat}/${roomPreview._id}`"
                        target="_blank"
                        class="block w-4 h-4 text-white text-center bg-background-primary leading-4 rounded-full pr-4"
                        title="Profile"
                    >
                        P
                    </a>
                </div>
            </div>
        </DisclosurePanel>
    </Disclosure>
</template>

<script>
import {Disclosure, DisclosureButton, DisclosurePanel} from "@headlessui/vue";
import PersonalSidebarRoomCell from "@/components/frontend/personalSidebar/PersonalSidebarRoomCell.vue";
import StatusIcon from "@/components/partials/StatusIcon.vue";
import {mapMutations, mapGetters} from "vuex";

export default {
    name: "PersonalSliderDisclosure",
    data() {
        return {
            expanded: false,
            user: {},
            openDisclosure: false,
        }
    },
    components: {StatusIcon, PersonalSidebarRoomCell, DisclosurePanel, DisclosureButton, Disclosure},
    props: {
        title: String,
        roomPreviews: Object,
        section: String,
        showLikes: Boolean,
    },
    methods: {
        ...mapMutations([
            "setRoomModal"
        ]),
        setIsOpenDisclosure() {
            this.openDisclosure = !this.openDisclosure;
        },
        handleRoomPopUpSwitch(room) {
            this.setRoomModal(room);
        },
    },
    computed: {
        ...mapGetters([
            "getStatuses",
            "getChats",
        ]),
    }
}
</script>

<style scoped>

</style>
