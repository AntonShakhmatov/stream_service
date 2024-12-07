<template>
  <li
    class="flex items-center justify-between gap-2 my-2 text-white text-sm list-none"
  >
    <div class="w-40 flex flex-col gap-1">
      <div class="flex items-center gap-2">
        <font-awesome-icon :icon="['fass', 'circle']" :class="statusClass" :title="getStatuses[0][room?.status]" />
        <span class="overflow-hidden overflow-ellipsis text-[12px]">
          {{ room.username }}
        </span>
        <span
          class="w-5 h-5 bg-contain bg-no-repeat bg-chaturbate bg-center"
          :style="chatLogo"
        ></span>
        <span
          class="block w-4 h-4 text-white text-center bg-third-color leading-4 rounded-full cursor-pointer"
          @click="handleRoomPopUpSwitch"
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
      <div class="flex items-center gap-2 text-white">
        <font-awesome-icon :icon="['fass', 'chart-line']" icon="" />
        <span> + {{ room.viewersIncrease }} </span>
        <span> / {{ room.viewers }}</span>
      </div>
    </div>
  </li>
</template>

<script>
import {mapGetters} from "vuex";

export default {
  name: 'PersonalSideBarTrendingRoomItem',
    props: {
    room: {
      type: Object,
      required: true,
    },
  },
  computed: {
      ...mapGetters([
          "getStatuses",
          "getChats",
      ]),
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
    chatLogo() {
        return require(`@/assets/chats/${this.getChats[0][this.room.chat]}.png`)
      // return `background-image: url("${''}");`
    },
  },
  methods: {
    handleRoomPopUpSwitch() {
      // if (this.room._id === this.openRoomID) {
      //       this.SET_IS_POP_UP_OPEN(false)
      //       this.SET_POP_UP_ID(null)
      //   } else {
      //       this.SET_IS_NOTES_OPEN(false)
      //       this.openPopUp({ popUpID: this.room._id, popUpOpen: true })
      //   }
    },
  },
}
</script>
