<template>
  <div class="aspect-w-4 aspect-h-3 relative">
      <div
          class="h-full w-full absolute object-cover flex flex-col justify-end bg-cover bg-no-repeat overflow-hidden transform transition-all rounded-md hover:scale-105 hover:z-10 cursor-pointer"
          v-if="!room?._id"
      >
          <loading
              :active="!room?._id"
              :can-cancel="false"
              :is-full-page="false"
              loader="bars"
              background-color="#fff"
              z-index="0"
          />
      </div>
    <div
        v-else
      ref="gridItem"
      class="h-full w-full absolute object-cover flex flex-col justify-end bg-cover bg-no-repeat overflow-hidden transform transition-all rounded-md hover:scale-105 hover:z-10 cursor-pointer"
      :style="roomImage"
      @click="openVideo"
    >
      <div
        v-if="room?.new === '1' && !room?.rank"
        class="h-10 w-10 absolute top-0 left-0 bg-new bg-cover bg-no-repeat rounded-tl-md"
      ></div>
      <span
        v-if="room?.rank"
        class="absolute top-0 left-0 z-10 inline-flex items-center bg-white justify-center rounded-full w-9 h-9 text-xs border border-red-500 text-red-500"
      >
        {{ room.rank }}.
      </span>
        <button @click.stop="newWindow" class="flex text-white py-1 px-3 rounded-md justify-end mt-2 text-lg">
            <font-awesome-icon :icon="['fas', 'window-restore']" />
        </button>

      <div
        class="mt-auto text-xs font-bold inline-flex justify-between h-[min-content] text-white"
      >
        <div
          v-if="room?.score"
          class="w-[max-content] px-1 inline-flex items-center bg-secondary-color bg-opacity-50 opacity-100"
        >
          <span v-if="$route.params.category === 'chaturbate-most-popular'">
            Points:
          </span>
          <span
            v-else-if="$route.params.category === 'chaturbate-most-followed'"
          >
            Followers:
          </span>
          <span v-else> Score: </span>
          {{ room?.score }}
        </div>
        <font-awesome-icon
          :icon="['fas', 'fire']"
          class="text-red-400 text-xl"
        />
      </div>
      <footer
        v-show="thumbnail"
        class="h-[min-content] w-full p-0.5 opacity-100 bg-secondary-color bg-opacity-50"
      >
        <div class="flex items-center justify-between gap-2 text-[12px]">
          <span class="flex gap-2 items-center overflow-hidden">
            <font-awesome-icon :icon="['fas', 'circle']" :class="statusClass" :title="getStatuses[0][room?.status]" />
            <span
              class="text-white font-bold overflow-hidden overflow-ellipsis whitespace-nowrap"
              >{{ room?.username }}
            </span>
          </span>
          <span class="flex items-center gap-2">
            <span class="text-white">{{ room?.age }}</span>
            <font-awesome-icon
              :icon="['fas', genderIcon]"
              class="block text-[12px] text-white"
              :title="room?.gender"
            />
                <img
                    :src="`/assets/flags/${room?.img_flag}`"
                    :alt="room?.location"
                    :title="room?.location"
                    v-if="room?.img_flag"
                    class="h-3 w-3 !bg-cover !bg-no-repeat"
                />
                <img
                    src="/assets/flags/unspecified-country.png"
                    class="h-3 w-3 !bg-cover !bg-no-repeat"
                    :title="room?.location"
                    :alt="room?.location"
                    v-else
                />
          </span>
        </div>
        <div class="flex items-center gap-2 text-[12px]" v-if="room?._id">
          <a
            :href="room?.chatUrl"
            target="_blank"
            :title="getChats[0][room?.chat]"
            class="h-4 w-4 bg-contain bg-no-repeat"
            :style="chatLogo"
          ></a>
          <span class="text-white">{{ room?.viewers }}</span>
          <font-awesome-icon :icon="['fas', 'eye']" class="text-white" />
          <span v-if="room?.hd === '1'" class="text-white font-bold">|HD</span>
            <button
                class="block w-4 h-4 ml-auto text-white text-center bg-background-primary leading-4 rounded-full"
                title="Menu"
                @click.stop="handleRoomPopUpSwitch()"
            >
                M
            </button>
          <button
            class="block w-4 h-4 text-white text-center bg-third-color leading-4 rounded-full"
            title="Profil"
            @click.stop="showProfile"
          >
            P
          </button>
        </div>
      </footer>
    </div>
  </div>
</template>

<script>

import {mapMutations, mapGetters} from "vuex";
import CountryFlag from 'vue-country-flag-next'
import Loading from 'vue3-loading-overlay';
// Import stylesheet
import 'vue3-loading-overlay/dist/vue3-loading-overlay.css';

export default {
    name: "RoomItem",
  props: {
    room: {
      type: Object,
      required: false,
    },
  },
    components: {
      CountryFlag,
        Loading,
    },
    data() {
        return {
            thumbnail: true,
        }
    },
    created() {
        this.thumbnail = this.getActiveFilter.thumbnail;
    },
    computed: {
        ...mapGetters([
            "getActiveFilter",
            "getTopRatedRooms",
            "getStatuses",
            "getChats"
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
    link() {
      return `/window-preview/${this.room.username}/${this.room.chat}/${this.room._id}`
    },
    roomImage() {
      return `background-image: url(${this.room.preview_image});`
    },
    chatLogo() {
        return `background-image: url('/assets/chats/${this.getChats[0][this.room.chat]}.png')`;
    },
    statusClass() {
        switch (this.room.status) {
            case 4:
                return "text-yellow-600";
            case 6:
                return "text-purple-500";
            case 0:
                return "text-black";
            case 1:
                return "text-green-400";
            case 2:
                return "text-yellow-500";
            case 5:
                return "text-gray-500";
            case 3:
                return "text-red-500";
            default:
                return "text-black";
        }
    },
  },
  methods: {
        ...mapMutations([
            'setRoomVideo',
            "setProfileRoom",
            "setRoomModal",
        ]),
    newWindow() {
      const date = new Date()
      const mSec = date.getTime()
      const myWindow = window.open(
          `/room-preview/${this.room.username}/${this.room.chat}/${this.room._id}`,
        'Popup' + mSec,
        'width=850,height=600'
      )
      myWindow?.focus()
    },
    showProfile() {
        this.setProfileRoom(this.room);
      window
        .open(
          `/profile/${this.room.username}/${this.room.chat}/${this.room._id}`,
          '_blank'
        )
        ?.focus()
      /* this.$router.push({
        name: 'profile-id',
        params: { id: JSON.stringify(this.room._id) },
      }) */
    },
    openVideo() {
        this.setRoomVideo(this.room);
        window.scrollTo(0,0);
    },
    handleRoomPopUpSwitch() {
        this.setRoomModal(this.room);
    },
  },
    watch: {
        "getActiveFilter.thumbnail": function (val, oldVal) {
            this.thumbnail = this.getActiveFilter.thumbnail;
        }
    }
}
</script>

<style scoped>
.aspect-ration {
  padding-top: 80%;
}
</style>
