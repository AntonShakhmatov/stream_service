<template>
    <button
        :disabled="disabled"
        :class="[
      disabled && '!opacity-50 ',
      !active && 'bg-secondary-color',
      active && 'bg-primary-color hover:bg-grid-color',
      `py-1 px-3 transition-all  text-white font-bold rounded-md hover:bg-third-color`,
    ]"
        @click="$emit('clicked')"
    >
        <slot />
    </button>
</template>
<script setup>
defineProps({
    active: {
        type: Boolean,
        default: false,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
</script>