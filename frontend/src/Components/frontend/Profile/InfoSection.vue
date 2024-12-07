<template>
    <div class="!w-96 h-min p-2 bg-background-secondary !text-sm rounded-md text-white">
        <div class="flex flex-col gap-2">
            <section class="grid grid-cols-2 gap-2">

                <img
                    v-if="false"
                    class="aspect-4/3 w-full bg-cover rounded-md bg-no-repeat"
                    :src="photo.url"
                    :alt="`photo ${idx}`"
                />
            </section>
            <section>
                <div class="flex items-center justify-between gap-2">
                    <span class="text-xl text-primary font-bold">
                        {{ room?.username.substr(0, 15) }}
                    </span>
                    <span class="block w-6 h-6 bg-cover bg-no-repeat bg-chat-logo"></span>
                </div>
            </section>
            <section>
                <p class="text-[#b3b3b3]">
                    {{ room?.subject }}
                </p>
            </section>
            <section>
                <h1 class="text-primary text-lg font-bold uppercase">Basic</h1>
                <div class="grid grid-cols-2 gap-1 mt-1">
                    <span>Age</span>
                    <span>
                      {{ room?.age || '-' }}
                    </span>
                    <span>Gender</span>
                    <span>
                        {{ getGender() || '-' }}
                    </span>
                    <span>Ethnicity</span>
                    <span>
                        {{ room?.ethnicity || '-' }}
                    </span>
                </div>
            </section>
            <section>
                <h1 class="text-primary text-lg font-bold uppercase">Numbers</h1>
                <div class="grid grid-cols-2 gap-1 mt-1">
                    <span>First seen</span>
                    <span>
                        {{ formatDate(room?.first_seen) || '-' }}
                    </span>
                    <span>Last seen</span>
                    <span>
                      {{ formatDate(room?.last_seen) || '-' }}
                    </span>
                    <span>Avg. Room ppl</span>
                    <span>
                      {{ stats?.avg_viewers || '-' }}
                    </span>
                    <span>Most Room ppl</span>
                    <span>
                      {{ stats?.max_viewers || '-' }}
                    </span>
                    <span v-if="isRoom('chaturbate')">CB Followers</span>
                    <span v-if="isRoom('chaturbate')">
                      {{ room?.cb_followers || '-' }}
                    </span>
                    <span v-if="isRoom('myfreecams')">MFC camscore</span>
                    <span v-if="isRoom('myfreecams')">
                          {{ room?.mfc_score || '-' }}
                    </span>
                    <span v-if="isRoom('myfreecams')">Miss MFC </span>
                    <span v-if="isRoom('myfreecams')">
                        {{ room?.mfc_rank || '-' }}
                    </span>
                </div>
            </section>
            <section class="flex items-center justify-evenly">
                <button @click.stop="openNewWindow" class="text-white py-1 px-3 bg-primary-color rounded-md">
                    <font-awesome-icon :icon="['fas', 'window-restore']" />
                </button>
                <a
                    :href="room?.chat_url"
                    target="_blank"
                    class="text-white py-1 px-3 bg-primary-color rounded-md hover:cursor-pointer"
                >
                    <font-awesome-icon :icon="['fas', 'link']" />
                </a>
            </section>
                <section>
                    <TabGroup>
                        <TabList class="flex gap-2 mb-2">
                            <Tab as="Fragment">
                                <BaseButton
                                    class="w-full hover:text-white hover:!bg-primary-color"
                                    :class="{'!bg-primary-color !hover:accent-blue-900': selected === 'bio'}"
                                    @click="setSelected('bio')"
                                >
                                    Bio
                                </BaseButton>
                            </Tab>
                            <Tab as="Fragment">
                                <BaseButton
                                    class="w-full hover:text-white hover:!bg-primary-color"
                                    :class="{'!bg-primary-color !hover:accent-blue-900': selected === 'times'}"
                                    @click="setSelected('times')"
                                >
                                    Online times
                                </BaseButton>
                            </Tab>
                        </TabList>
                        <TabPanels>
                            <TabPanel>
                                <BioTable :room="room" />
                            </TabPanel>
                            <TabPanel>
                                <OnlineTimesTable :room="room" />
                            </TabPanel>
                        </TabPanels>
                    </TabGroup>
                </section>
        </div>
    </div>
</template>

<script>
import {Tab, TabGroup, TabList, TabPanel, TabPanels} from "@headlessui/vue";
import BaseButton from "@/components/partials/BaseButton.vue";
import BioTable from "@/components/frontend/Profile/BioTable.vue";
import OnlineTimesTable from "@/components/frontend/Profile/OnlineTimesTable.vue";
import dayjs from "dayjs";
import {parseGender} from "@/helpers";

export default {
    name: "InfoSection",
    components: {OnlineTimesTable, BioTable, BaseButton, TabPanel, TabPanels, Tab, TabList, TabGroup, dayjs},
    props: {
        room: Object,
        stats: Object,
    },
    data() {
        return {
            selected: "bio",
        }
    },
    methods: {
        setSelected(val) {
            this.selected = val;
        },
        openNewWindow() {
            const date = new Date()
            const mSec = date.getTime()
            const myWindow = window.open(
                `/room-preview/${this.room.username}/${this.room.chat}/${this.room._id}`,
                'Popup' + mSec,
                'width=850,height=600'
            )
            myWindow?.focus()
        },
        isRoom(roomName) {
            return this.room?.chat === roomName;
        },
        formatDate(date) {
            return dayjs(date?.substring(0,10)).format("DD.MM.YYYY");
        },
        getGender() {
            return parseGender(this.room.gender);
        },

    },
}
</script>

<style scoped>

</style>
