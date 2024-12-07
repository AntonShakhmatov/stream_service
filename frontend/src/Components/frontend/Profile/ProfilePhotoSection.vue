<template>
    <div>
        <h2 class="title mt-5">Photos</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-5 mt-5">
            <img
                v-for="(photo, idx) in photos"
                class="aspect-4/3 w-full bg-cover rounded-md bg-no-repeat"
                :src="photo.url"
                :alt="`photo ${idx}`"
            />
        </div>
    </div>
</template>

<script>
export default {
    name: "ProfilePhotoSection",
    props: {
        photos: Object,
    }
}
</script>

<style scoped>

</style>
