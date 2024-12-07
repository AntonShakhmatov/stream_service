<template>
    <span class="text-white pr-3 items-center">Refresh rate: {{ currentRefreshRate() }}</span>
    <Popover class="relative" v-slot="{ open, close }">
        <popover-button as="refresh-button">
            <div>
                <button class="px-3 py-[0.4rem] transition-all text-white text-sm rounded-md border border-white bg-primary-color hover:bg-secondary-color"
                        ref="refreshIcon"
                        @click="(e) => hoverPopover(e, open)"
                >
                    <font-awesome-icon :icon="['fas', 'circle-chevron-down']" v-show="!popoverHover" />
                    <font-awesome-icon :icon="['fas', 'circle-chevron-up']" v-show="popoverHover" />
                </button>
            </div>
        </popover-button>
        <Transition
            as="refresh-button"
            enter="transition ease-out duration-200"
            enterFrom="opacity-0 translate-y-1"
            enterTo="opacity-100 translate-y-0"
            leave="transition ease-in duration-150"
            leaveFrom="opacity-100 translate-y-0"
            leaveTo="opacity-0 translate-y-1"
        >
            <popover-panel class="absolute left-0 top-7 mb-5 z-10 bg-secondary-color rounded-md overflow-hidden border-white">
                <div class="mb-5 md:w-60 md:sticky top-0 bg-background-secondary rounded-md overflow-hidden border-white">
                    <ul>
                        <li style="border-bottom: 1px solid white;">
                            <button class="text-white px-5 py-2 hover:text-primary-color" @click.prevent="selectedRefresh(0)">
                                Manually
                            </button>
                        </li>
                        <li style="border-bottom: 1px solid white;">
                            <button class="text-white px-5 py-2 hover:text-primary-color" @click.prevent="selectedRefresh(120);">2 minutes</button>
                        </li>
                        <li style="border-bottom: 1px solid white;">
                            <button class="text-white px-5 py-2 hover:text-primary-color" @click.prevent="selectedRefresh(300)">5 minutes</button>
                        </li>
                    </ul>
                </div>
            </popover-panel>
        </Transition>
    </Popover>
</template>

<script setup>
import {ref, reactive} from 'vue'
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue';
import {useStore} from "vuex";
import { useRoute } from 'vue-router';


const popoverHover = ref(false)
const popoverTimeout = ref(null);
let refreshIcon = ref(null);
const refreshRate = ref(120);
const store = useStore();
const route = useRoute();
const queryParams = reactive(route.query);
const page = queryParams?.page ?? 1;


const hoverPopover = (e, open) => {
    popoverHover.value = !popoverHover.value;
    console.log(e);
}

const closePopover = (close) => {
    popoverHover.value = false
    if (popoverTimeout.value) clearTimeout(popoverHover.value)
    popoverTimeout.value = setTimeout(() => {
        if (!popoverHover.value) close()
    }, 100)
}

const selectedRefresh = val => {
    refreshRate.value = val;
}
const currentRefreshRate = () => {
    switch (refreshRate.value) {
        case 120:
            return "2 minutes";
        case 300:
            return "5 minutes";
        case 0:
            return "Manually";
        default:
            return "2 minutes";
    }
}
const refresh = () => {
    store.dispatch("fetchRooms", {page: page, filter: store.getters.getActiveFilter});
}
</script>

<style scoped>

</style>