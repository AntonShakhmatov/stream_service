<template>
  <section class="md:flex gap-5 mt-5">
    <slot />
    <div
      :class="[
        loading && 'animate-pulse',
        'flex-grow max-w-full h-[min-content] grid gap-3 grid-rows-max-content',
        gridSizeClass,
      ]"
    >
      <div v-for="room in rooms" :key="room._id">
        <RoomItem
          v-if="room._id !== null"
          :room="room"
          :loading="loading"
        />
        <EmptyRoomItem v-else :room="room" />
      </div>
    </div>
  </section>
</template>

<script >

import RoomItem from "@/Pages/Frontend/RoomItem.vue";
import EmptyRoomItem from "@/Pages/Frontend/EmptyRoomItem.vue";

export default {
    name:"RoomsGrid",
    components: {EmptyRoomItem, RoomItem},
    props: {
    rooms: {
      type: Array,
      required: true,
    },
    gridSize: {
      type: Number,
    },
    thin: {
      type: Boolean,
      default: false,
    },
    loading: {
      type: Boolean,
      required: true,
    },
  },
  computed: {
    gridSizeClass() {
      if (this.gridSize === 1) {
        if (this.thin) {
          return 'grid-cols-1 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5'
        }
        return 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6'
      } else if (this.gridSize === 2) {
        if (this.thin) {
          return 'grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-7'
        }
        return 'grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-8'
      } else {
        if (this.thin) {
          return 'xl:grid-cols-6 2xl:grid-cols-8'
        }
        return 'xl:grid-cols-7 2xl:grid-cols-10'
      }
    },
  },
}
</script>

<style scoped>
.grid-rows-max-content {
  grid-template-rows: max-content;
}
</style>
