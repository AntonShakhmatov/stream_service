<template>
    <div class="min-h-screen bg-[#252526]">
        <TheHeader :filter="filter" />
        <main class="min-h-screen">
            <PersonalSideBar />
            <div class="my-container min-h-screen pt-[90px]">
                <slot></slot>
                <RoomModal />
                <NotesModal />
            </div>
        </main>
        <footer class="bg-background-secondary mt-10 h-32">
          <span class="block pt-10 text-center text-white">
            Copyright © 2020 mycamstars.net | livechat
          </span>
        </footer>
    </div>
</template>

<script>

import TheHeader from "@/components/navigations/TheHeader.vue";
import PersonalSideBar from "@/components/frontend/PersonalSideBar.vue";
import RoomModal from "@/components/frontend/modals/RoomModal.vue";
import NotesModal from "@/components/frontend/modals/NotesModal.vue";


export default {
    name:"MainLayout",
    props: {
        filter: Object|null,
    },
    components: {
        TheHeader,
        PersonalSideBar,
        RoomModal,
        NotesModal,
    }
}
</script>

<style>
.aspect-video {
    aspect-ratio: 16 / 9;
}
</style>
