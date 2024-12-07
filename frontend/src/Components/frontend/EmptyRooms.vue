<template>
    <div class="w-full m-auto text-center">
        <font-awesome-icon :icon="['fas', 'face-sad-cry']" class="mx-auto h-12 w-12 text-white"/>

        <h3 class="mt-2 text-xl font-medium text-white">No rooms</h3>
        <p class="mt-1 text-sm text-white">There are no rooms available</p>
        <div class="mt-6">
            <BaseButton @click="reload" class="!px-4 !py-2">
                Reset filter
            </BaseButton>
        </div>
    </div>
</template>
<script>
import BaseButton from "@/components/partials/BaseButton.vue";
export default {
    name: "EmptyRooms",
    components: {BaseButton},
    methods: {
        reload() {
            window.location = '/';
        }
    }
}
</script>
