<template>
    <LayoutAuthenticated>
        <Head title="Rooms" />
        <SectionMain>
            <SectionTitleLineWithButton :icon="mdiTableBorder" title="Rooms" :has-cog="false"/>
            <CardBox class="mb-6" has-table>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Chat</th>
                            <th>Gender</th>
                            <th>Age</th>
                            <th>Location</th>
                            <th>Viewers</th>
                            <th>Status</th>
                            <th>New</th>
                            <th>Language</th>
                            <th>Likes</th>
                            <th>Followers</th>
                            <th>First seen</th>
                            <th>Last seen</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="room in rooms.data">
                            <td>{{ room.id }}</td>
                            <td>{{ room.username }}</td>
                            <td>{{ room.chat }}</td>
                            <td>{{ room.gender }}</td>
                            <td>{{ room.age ? room.age : '-' }}</td>
                            <td>{{ room.location }} {{ room.flag ? '-' : ''}} <span :class="`fi fi-${room.flag}`"></span></td>
                            <td>{{ room.viewers }}</td>
                            <td><BaseIcon :path="mdiCircle" :class="room.status !== 'offline' ? 'text-green-500' : 'text-red-500'" /></td>
                            <td>{{ room.new ? 'Yes' : 'No' }}</td>
                            <td>{{ room.language }}</td>
                            <td>{{ room.likes }}</td>
                            <td>{{ room.saves }}</td>
                            <td>{{ room.first_seen ? room.first_seen : '-' }}</td>
                            <td>{{ room.last_seen ? room.last_seen : '-' }}</td>
                            <td>
                                <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                    <BaseButton color="info" :icon="mdiPencil" small :href="route('rooms.edit', room.id)" />
                                    <BaseButton color="info" :icon="mdiEye" small @click="showModalRoom(room)" />
                                </BaseButtons>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination :data="rooms" :centered="true" />

                <CardBoxModal v-model="isModalShowActive" title="Zobrazenie room" button="info" @confirm="showRoom = {}">
                    <RoomView :room="showRoom" v-if="showRoom?.id" />
                </CardBoxModal>

            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>

<script setup>
import {Head} from '@inertiajs/vue3'
import {ref} from "vue";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import BaseButton from "@/Components/BaseButton.vue";
import SectionMain from "@/Components/SectionMain.vue";
import CardBox from "@/Components/CardBox.vue";
import {mdiEye, mdiCircle, mdiPencil, mdiTableBorder} from "@mdi/js";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import Pagination from "@/Components/Pagination.vue";
import "/node_modules/flag-icons/css/flag-icons.min.css";
import BaseIcon from "@/Components/BaseIcon.vue";
import CardBoxModal from "@/Components/CardBoxModal.vue";
import RoomView from '@/Pages/Rooms/View.vue'

const props = defineProps({
    rooms: Object,
});

const showRoom = ref({});
const isModalShowActive =  ref(false);

const showModalRoom = (room) => {
    showRoom.value = room;
    isModalShowActive.value = true;
}



</script>


