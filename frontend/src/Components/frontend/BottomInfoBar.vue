<template>
    <div>
        <footer class="absolute bottom-0  h-[min-content] w-full opacity-100">

            <font-awesome-icon class="text-red-400 text-xl" :icon="['fas', 'fire']" v-show="checkIfRoomIsTrending()"/>

            <div class="bg-secondary-color bg-opacity-50">
                <div class="text-xs font-bold inline-flex justify-between h-[min-content] text-white p-0.5" v-if="room.points">
                    <div class="w-[max-content] px-1 inline-flex items-center bg-secondary-color bg-opacity-50 opacity-100" >
                        <span>Score:</span>
                        {{ room.points }}
                    </div>
                </div>

                <div class="bg-background-primary bg-opacity-50 p-0.5">
                    <div class="flex items-center justify-between gap-2 text-[12px]">
                        <div class="flex gap-2 items-center overflow-hidden">
                            <font-awesome-icon :icon="['fas', 'circle']" :class="roomStatus()" :title="getStatuses[0][room.status]" />
                            <span class="text-white font-bold overflow-hidden overflow-ellipsis whitespace-nowrap">
                                {{ room.username }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-white">{{ room.age }}</span>
                            <font-awesome-icon :icon="['fas', genderIcon()]" class="block text-[12px] text-white" :title="gender()" />
                            <img
                                :src="`../../assets/flags/${room?.img_flag}`"
                                :alt="room?.location"
                                :title="room?.location"
                                v-if="room?.img_flag"
                                class="h-3 w-3 !bg-cover !bg-no-repeat"
                            />
                            <img
                                src="../../assets/flags/unspecified-country.png"
                                class="h-3 w-3 !bg-cover !bg-no-repeat"
                                :title="room.location"
                                :alt="room.location"
                                v-else
                            />
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-[12px]">
                        <a
                            :href="room.chatUrl"
                            target="_blank"
                            :title="getChats[0][room.chat]"
                            class="h-4 w-4 bg-contain bg-no-repeat"
                            :style="chatImageURL()"
                        ></a>
                        <span class="text-white">{{ room.viewers }}</span>
                        <font-awesome-icon class="text-white" :icon="['fas', 'eye']" />
                        <span class="text-white font-bold" v-if="room.hd">|HD</span>
                        <button
                            class="block w-4 h-4 ml-auto text-white text-center bg-background-primary leading-4 rounded-full"
                            title="Menu"
                            @click.stop="openRoomModal()"
                        >
                            M
                        </button>
                        <a
                            @click.stop="showProfile"
                            class="block w-4 h-4 text-white text-center bg-background-primary leading-4 rounded-full"
                            title="Profile"
                        >
                            P
                        </a>
                    </div>
                </div>
            </div>

        </footer>
    </div>
</template>

<script>
import {mapMutations,mapGetters, mapActions} from "vuex";
import CountryFlag from "vue-country-flag-next";
import {parseGender} from "@/helpers";

export default {
    name: "BottomInfoBar",
    props: {
        room: Object,
    },
    methods: {
        ...mapMutations([
            "setProfileRoom",
            "setRoomModal",
        ]),
        ...mapActions([
            "parseRoomGender",
        ]),
        checkIfRoomIsTrending() {
            return this.getTopRatedRoomIds.includes(this.room._id);
        },
        roomStatus() {
            switch (this.room.status) {
                case 'offline':
                    return "text-black";
                case 'free chat':
                    return "text-green-400";
                case 'group show':
                    return "text-yellow-500";
                case 'private chat':
                    return "text-red-500";
                case 'away':
                    return "text-gray-500";
                case 'ticket show':
                    return "text-blue-500";
                case 'true private':
                    return "text-purple-500";
                default:
                    return "text-black";
            
            }
        },
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
        gender() {
            return parseGender(this.room.gender);
        },
        chatImageURL() {
            const chatName = this.getChats[0][this.room.chat];
            return `background-image: url('/assets/chats/${chatName}.png')`;
        },
        showProfile() {
            this.setProfileRoom(this.room);
            window
                .open(
                    `/profile/${this.room.username}/${this.room.chat}/${this.room._id}`,
                    '_blank'
                )
                ?.focus()
        },
        openRoomModal() {
            this.setRoomModal(this.room);
        }
    },
    computed: {
        ...mapGetters([
            "getTopRatedRoomIds",
            "getChats",
            "getStatuses",
        ])
    },
    components: {
        CountryFlag,
    }
}
</script>

<style scoped>

</style>
