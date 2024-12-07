<template>
    <aside class="p-4 h-full lg:h-screen md:sticky w-full lg:w-70 top-20 mt-6 bg-secondary-color rounded-md">
        <h1 class="text-xl text-primary-color">TOP 1000</h1>
        <hr class="mt-2 border-background-primary border-2" />
        <h2 class="my-4 text-xl text-white">Chaturbate</h2>
        <div class="flex flex-col gap-2 text-white" >
            <router-link :to="{name: 'stats', params: {room: 'chaturbate-most-followed'}}" class="hover:text-primary-color" :class="{'font-bold text-primary-color': roomName === 'chaturbate-most-followed'}">
                Most followed rooms
            </router-link>
            <router-link :to="{name: 'stats', params: {room: 'chaturbate-most-popular'}}" class="hover:text-primary-color" :class="{'font-bold text-primary-color': roomName === 'chaturbate-most-popular'}">
                Most popular rooms
            </router-link>
        </div>
        <hr class="my-4 border-background-primary border-2" />
        <h2 class="my-4 text-xl text-white">Myfreecams</h2>
        <div class="flex flex-col gap-2 text-white">
            <router-link :to="{name: 'stats', params: {room: 'myfreecams-best-score'}}" class="hover:text-primary-color" :class="{'font-bold text-primary-color': roomName === 'myfreecams-best-score'}">
                MFC camscore
            </router-link>

            <router-link :to="{name: 'stats', params: {room: 'miss-mfc'}}" class="hover:text-primary-color" :class="{'font-bold text-primary-color': roomName === 'miss-mfc'}">
                Miss MFC
            </router-link>
        </div>
    </aside>
</template>

<script>

export default {
    name: "StatsSideBar",
    data() {
        return {
            roomName: ""
        }
    },
    created() {
        this.roomName = this.$route.params.room;
    },
    watch: {
        '$route.params': function () {
            this.roomName = this.$route.params.room;
        }
    }
}
</script>

<style scoped>

</style>
