<template>
  <div class="aspect-w-4 aspect-h-3 relative">
    <div
      class="h-full w-full absolute object-cover flex flex-col justify-end bg-default-preview bg-cover bg-no-repeat rounded-md hover:scale-105 hover:z-10"
    >
      <span
        v-if="room.rank"
        class="absolute top-0 left-0 z-10 inline-flex items-center bg-white justify-center rounded-full w-9 h-9 text-xs border border-red-500 text-red-500">
        {{ room.rank }} .
      </span>
      <footer
        v-show="thumbnail"
        class="h-[min-content] w-full p-0.5 opacity-100 bg-secondary-color bg-opacity-50"
      >
        <span
          class="text-white font-bold overflow-hidden overflow-ellipsis whitespace-nowrap"
          >{{ room.username }}
        </span>
      </footer>
    </div>
  </div>
</template>

<script>

export default {
    name: 'EmptyRoomItem',
    data() {
      return {
          thumbnail: false;
      }
    },
    props: {
        room: {
          type: Object,
          required: true,
        },
    },
}
</script>
