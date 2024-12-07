<template>
  <div class="flex flex-wrap gap-2 ml-2">
    <font-awesome-icon
      :icon="['fas', 'table-cells-large']"
      :class="[
        'inline-block text-2xl text-white p-2 rounded-md bg-secondary-color cursor-pointer transition-all hover:bg-third-color',
        value === 1 && '!bg-primary-color hover:bg-grid-color',
      ]"
      @click="$emit('input', 1)"
    />
    <font-awesome-icon
      :icon="['fas', 'table-cells']"
      :class="[
        'inline-block text-2xl text-white p-2 rounded-md bg-secondary-color cursor-pointer transition-all hover:bg-third-color',
        value === 2 && '!bg-primary-color hover:bg-grid-color',
      ]"
      @click="$emit('input', 2)"
    />
    <div class="hidden xl:inline-flex items-center justify-center p-2 rounded-md bg-secondary-color cursor-pointer transition-all hover:bg-third-color"
         :class="value === 3 && '!bg-primary-color'"
         @click="$emit('input', 3)"
    >
        <img
            src="@/assets/images/grid-max.png"
            class="w-5 h-5 object-fill"
            alt="big grid icon"
        />
    </div>
  </div>
</template>

<script>

export default {
  props: {
    value: {
      type: Number,
    },
  },
}
</script>

