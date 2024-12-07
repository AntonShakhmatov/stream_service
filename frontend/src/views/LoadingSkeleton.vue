<template>
    <div class="loading-skeleton" :style="`width: ${width}px; height: ${height}px`">
        <div class="loading-skeleton-row" :style="`background: linear-gradient(to right, #888 0%, #000 100%);height: ${height}px;`"></div>
    </div>
</template>
<script>
    export default {
        name: "LoadingWrapper",
        props: {
            width: {
                required: false,
                default: 300,
            },
            height: {
                required: false,
                default: 200
            }
        }
    }
</script>

<style scoped>
.loading-skeleton {
    background-color: #797979;
    border-radius: 4px;
    overflow: hidden;
}

.loading-skeleton-row {
    animation: loadingSkeletonAnimation 1.5s ease-in-out infinite;
}

@keyframes loadingSkeletonAnimation {
    0% { width: 0%; }
    100% { width: 100%; }
}
</style>
