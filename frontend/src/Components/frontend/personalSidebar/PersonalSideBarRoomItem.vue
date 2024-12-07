<template>
  <li class="flex items-center gap-2 my-2 text-white text-sm list-none">
    <fa-icon :icon="['fass', 'circle']" :class="statusClass" :title="room.status" />
    <span class="overflow-hidden overflow-ellipsis text-[12px]">
      {{ room.username }}
    </span>
    <span
      class="w-5 h-5 bg-contain bg-no-repeat bg-chaturbate bg-center"
      :style="chatLogo"
    ></span>
    <span
      class="block w-4 h-4 ml-auto text-white text-center bg-third-color leading-4 rounded-full cursor-pointer"
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
  </li>
</template>

<script>

export default {
  name: 'PersonalSideBarRoomItem',
  props: {
    room: {
      type: Object,
      required: true,
    },
  },
  computed: {
    statusClass() {
      if (this.room.status === 'free chat') {
        return 'text-green-400'
      }
      if (this.room.status === 'private chat') {
        return 'text-red-500'
      }
      if (this.room.status === 'club show') {
        return 'text-yellow-600'
      }
      if (this.room.status === 'group chat') {
        return 'text-yellow-500'
      }
      if (this.room.status === 'true private') {
        return 'text-purple-500'
      }
      if (this.room.status === 'away') {
        return 'text-gray-500'
      }
      return 'text-white'
    },
    chatLogo() {
      // const url = require(`@/assets/chats/${this.room.chat}.png`)
      return `background-image: url("${''}");`
    },
  },
  methods: {
    handleRoomPopUpSwitch() {
      // if (this.room._id === this.openRoomID) {
      //   this.SET_IS_POP_UP_OPEN(false)
      //   this.SET_POP_UP_ID(null)
      // } else {
      //   this.SET_IS_NOTES_OPEN(false)
      //   this.openPopUp({ popUpID: this.room._id, popUpOpen: true })
      // }
    },
  },
}
</script>
