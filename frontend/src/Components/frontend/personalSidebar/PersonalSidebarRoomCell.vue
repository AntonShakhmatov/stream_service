<template>

</template>

<script>
import StatusIcon from "@/components/partials/StatusIcon.vue";
import {mapMutations} from "vuex";

export default {
    name: "PersonalSidebarRoomCell",
    components: {StatusIcon},
    props: {
        roomPreview: Object,
        showLikes: Boolean,
    },
    methods:{
        ...mapMutations([
            "setRoomModal"
        ]),
        handleRoomPopUpSwitch() {
            this.setRoomModal(this.roomPreview);
        },
    }
}
</script>

<style scoped>

</style>
