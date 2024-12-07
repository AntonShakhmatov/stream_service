<template>
    <section class="mt-5">
        <div class="flex items-center gap-5">
            <h1 class="title">Top rated</h1>
            <BaseButton @click="setIsOpen">
            {{ isOpen ? 'Hide' : 'Show' }}
            </BaseButton>
        </div>
        <div class="relative">
            <button
                @click="prevSlide"
                class="absolute inline-flex flex-col justify-center left-0 top-0 h-full w-12 bg-background-secondary opacity-30 z-10 hover:opacity-75"
            >
                <font-awesome-icon :icon="['fas', 'chevron-left']" class="text-white" />
            </button>
            <div id="top-slider" class="snap-list mt-5 overflow-y-hidden" v-show="isOpen">
                <div v-if="topRated.length === 0" class="snap-list-child !h-full !p-0" v-for="key in 10">
                    <RoomItem class="w-full" />
                </div>
                <div v-for="(room, idx) in topRated" :key="idx" class="snap-list-child !h-full !p-0" v-else>
                    <RoomItem :room="room" class="w-full hover:scale-100" />
                </div>
            </div>
            <button
                @click="nextSlide"
                class="absolute inline-flex flex-col justify-center right-0 top-0 h-full w-12 bg-background-secondary opacity-30 z-10 hover:opacity-75"
            >
                <font-awesome-icon :icon="['fas', 'chevron-right']" class="text-white" />
            </button>
        </div>
    </section>
</template>

<script >
import BaseButton from "@/components/partials/BaseButton.vue";
import RoomItem from "@/components/frontend/RoomItem.vue";
import {mapGetters, mapActions} from "vuex";
import LoadingSkeleton from "@/views/LoadingSkeleton.vue";


export default {
    name: "TopRated",
    data() {
        return {
            isOpen: true,
            topRated: [],
            timer: "",
        }
    },
    async created() {
        await this.fetchTopRated();

        this.timer = setInterval(this.fetchTopRated, 120000);
    },
    mounted() {
        this.autoSlide()
    },
    methods: {
        ...mapActions([
            'fetchTopRatedRooms',
        ]),
        nextSlide() {
            const topSlider = document.querySelector('#top-slider')
            const topItemSize = topSlider?.querySelector('div')?.clientWidth
            topSlider?.scrollBy(topItemSize || 0, 0)
        },
        prevSlide() {
            const topSlider = document.querySelector('#top-slider')
            const topItemSize = topSlider?.querySelector('div')?.clientWidth
            topSlider?.scrollBy((topItemSize ?? 0) * -1 || 0, 0)
        },
        firstSlide() {
            const topSlider = document.querySelector('#top-slider')
            topSlider?.scrollTo(0, 0)
        },
        autoSlide() {
            let i = this.topRated?.length
            setInterval(() => {
                if (i === this.topRated?.length) {
                    this.firstSlide()
                    i = 1
                } else {
                    this.nextSlide()

                    i++
                }
            }, 3500)
        },
        setIsOpen() {
            this.isOpen = !this.isOpen;
        },
        async fetchTopRated() {
            await this.fetchTopRatedRooms();

            this.topRated = this.getTopRatedRooms
        },
        cancelAutoUpdate() {
            clearInterval(this.timer);
        }
    },
    computed: {
        ...mapGetters(['getTopRatedRooms']),
    },
    beforeUnmount() {
        this.cancelAutoUpdate();
    },
    components: {
        RoomItem,
        BaseButton,
        LoadingSkeleton
    }
}


</script>

<style scoped>
.snap-list {
    width: 100%;
    overflow-x: scroll;
    scroll-snap-type: x mandatory;
    display: flex;
    gap: 1rem;
    align-items: center;
    scroll-behavior: smooth;
}
.snap-list-child {
    scroll-snap-align: start;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    flex: 0 0 calc(20% - 1rem); /*  -1 rem because of grid gap */
}
@media (max-width: 640px) {
    .snap-list-child {
        scroll-snap-align: center;
        flex: 0 0 calc(100% - 1rem);
    }
}

@media (min-width: 640px) {
    .snap-list-child {
        scroll-snap-align: start;
        flex: 0 0 calc(50% - 1rem);
    }
}
@media (min-width: 1280px) {
    .snap-list-child {
        scroll-snap-align: start;
        flex: 0 0 calc(25% - 1rem);
    }
}
@media (min-width: 1536px) {
    .snap-list-child {
        scroll-snap-align: start;
        flex: 0 0 calc(20% - 1rem);
    }
}
/* Track */
::-webkit-scrollbar-track {
    box-shadow: inset 0 0 5px grey;
    border-radius: 10px;
}

</style>
