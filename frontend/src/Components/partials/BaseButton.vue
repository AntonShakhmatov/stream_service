<template>
    <button
        class="px-3 py-1 transition-all bg-secondary-color text-white text-sm rounded-md border border-white hover:bg-white hover:text-secondary-color"
    >
        <slot />
    </button>
</template>

<script>
export default {
    name: "BaseButton"
}
</script>
