<template>
    <popover class="relative w-1/2">
        <popover-button as="tags-button" class="h-full">
            <div>
                <BaseButton
                    class="w-full h-full"
                    id="closeTags"
                    @click="togglePopover"
                >
                    Tags
                </BaseButton>
            </div>
        </popover-button>
        <Transition
            as="tags-button"
            enter="transition ease-out duration-200"
            enterFrom="opacity-0 translate-y-1"
            enterTo="opacity-100 translate-y-0"
            leave="transition ease-in duration-150"
            leaveFrom="opacity-100 translate-y-0"
            leaveTo="opacity-0 translate-y-1"
        >
            <popover-panel class="absolute left-0 top-8 mb-5 md:w-72 z-10 h-screen bg-secondary-color rounded-md overflow-y-scroll overflow-x-hidden">
                <div class="mb-5 md:w-72 h-screen md:sticky top-0 bg-background-secondary rounded-md overflow-y-scroll">
                    <header class="p-4">
                        <popover-button
                            v-slot="{close}"
                            @click="togglePopover"
                            class="block ml-auto text-white text-3xl cursor-pointer"
                        >
                            <font-awesome-icon :icon="['fas', 'fa-times']"/>
                        </popover-button>
                    </header>
                    <table class="w-full table-fixed">
                        <thead>
                        <tr class="bg-primary-color text-white text-left">
                            <th
                                class="p-2 cursor-pointer"
                                @click="orderedTags"
                            >
                                Tag
                                <font-awesome-icon :icon="['fas', 'fa-sort-up']" v-show="orderTags === 'descending'" />

                                <font-awesome-icon :icon="['fas', 'fa-sort-down']" v-show="orderTags === 'ascending'" />
                            </th>
                            <th
                                class="p-2 cursor-pointer"
                                @click="orderNumberTags"
                            >
                                Rooms
                                <font-awesome-icon :icon="['fas', 'fa-sort-up']" v-show="numberOrderTags === 'descending'" />
                                <font-awesome-icon :icon="['fas', 'fa-sort-down']" v-show="numberOrderTags === 'ascending'" />
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="(tag, idx) in tagList.data"
                            @click="setSelectedTag(tag.name)"
                            class='cursor-pointer text-white font-bold'
                            :class="[idx % 2 !== 0 ? 'bg-third-color' : 'bg-secondary-color', filter.tag.includes(tag.name) && '!bg-primary-color']"
                        >
                        <td class="p-2 whitespace-nowrap overflow-hidden overflow-ellipsis">
                            {{ tag.name }}
                        </td>
                        <td class="p-2">{{ tag.count }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </popover-panel>
        </Transition>
    </popover>
</template>

<script>
import {Popover, PopoverButton, PopoverPanel} from "@headlessui/vue";
import BaseButton from "@/components/partials/BaseButton.vue";
import {mapGetters,mapActions} from "vuex";
import _ from "lodash";

export default {
    name: "TagsFilter",
    components: {PopoverPanel, BaseButton, PopoverButton, Popover},
    data() {
        return {
            tagList: [],
            filter: [],
            closePopover: false,
            orderTags: 'descending',
            numberOrderTags: 'descending',
        }
    },
    async created() {
        await this.fetchTags();
        this.tagList = this.getTags;
        this.filter = this.getActiveFilter;
    },
    methods: {
        ...mapActions([
            'fetchTags'
        ]),
        orderedTags () {
            const tagsCopy = this.tagList.data;

            this.orderTags = this.orderTags === "descending" ? "ascending" : "descending";
            console.log(this.orderTags)
            return this.orderTags === "descending" ? tagsCopy.sort((a, b) => a.name.localeCompare(b.name) * -1) : tagsCopy.sort((a, b) => a.name.localeCompare(b.name));
        },
        orderNumberTags() {
            const tagsCopy = this.tagList.data;
            this.numberOrderTags = this.numberOrderTags === "descending" ? "ascending" : "descending";

            return this.numberOrderTags === "descending" ? tagsCopy.sort((a, b) => b.count - a.count) : tagsCopy.sort((a, b) => a.count - b.count);
        },
        setSelectedTag(val) {
            if (_.includes(this.filter?.tag, val)) {
                this.filter.tag = this.filter.tag.filter((el) => el !== val);
            } else {
                this.filter?.tag.push(val);
            }
            this.$emit('setSelectedTag')
        },
        togglePopover() {
            this.closePopover = !this.closePopover;
        },
    },
    computed: {
        ...mapGetters([
            'getTags',
            "getActiveFilter",
        ]),
    }
}
</script>

<style scoped>

</style>
