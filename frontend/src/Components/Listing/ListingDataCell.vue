<template>
  <td
    class="px-3 py-4 text-sm text-white first-of-type:pl-4 last-of-type:pr-4 first-of-type:sm:pl-6 last-of-type:sm:pr-6"
    :class="cellClass"
  >
    <slot />
  </td>
</template>

<script setup lang="ts">
interface Props {
    cellClass?: string;
}
defineProps<Props>()
</script>
