<template>
    <font-awesome-icon :icon="['fas', 'circle']" :class="roomStatus()" />
</template>

<script>
export default {
    name: "StatusIcon",
    props: {
        status: String,
    },
    methods: {
        roomStatus() {
            switch (this.status) {
                case "club show":
                    return "text-yellow-600";
                case "true private":
                    return "text-purple-500";
                case "offline":
                    return "text-black";
                case "free chat":
                    return "text-green-400";
                case "group chat":
                    return "text-yellow-500";
                case "away":
                    return "text-gray-500";
                case "private chat":
                    return "text-red-500";
                default:
                    return "text-black";
            }
        },
    }
}
</script>

<style scoped>

</style>
