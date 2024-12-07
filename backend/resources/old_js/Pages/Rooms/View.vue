<template>
    <div>
        <p>Username:</p>
        <span class="font-bold pl-5">{{ room.username }}</span>
    </div>
</template>

<script setup>
// import {defineProps} from "vue";

const props = defineProps({
    room: Object,
})

</script>

