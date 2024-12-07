<template>
  <v-select
    class="style-chooser font-bold text-white"
    :options="options"
    :multiple="multiple"
    :value="value"
    @input="$emit('onSelect', $event)"
  >
    <template v-slot:option="option">
      <span class="text-white">
        {{ option.label }}
      </span>
    </template>
  </v-select>
</template>

<script>
import vSelect from "vue-select"
export default {
    name: "MyVueSelect",
    components: {
        vSelect
    }
}
// export default Vue.extend({
//   props: {
//     options: {
//       type: Array,
//       required: true,
//     },
//     multiple: {
//       type: Boolean,
//       default: false,
//     },
//     value: {
//       type: [Array, Object, String],
//       default: () => [],
//     },
//   },
// })
</script>

<style>
.style-chooser .vs__search::placeholder,
.style-chooser .vs__dropdown-toggle,
.style-chooser .vs__dropdown-menu {
  background: #0d0d0d;
  border: none;
  color: white !important;
  text-transform: lowercase;
  font-variant: small-caps;
}

.style-chooser .vs__clear,
.style-chooser .vs__open-indicator {
  fill: #0177e5;
  color: white;
}

.style-chooser .vs__selected {
  color: #0177e5 !important;
}

#vs1__listbox {
  color: white !important;
  display: block !important;
}
</style>
