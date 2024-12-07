<template>
    <PageHeader title="Rooms">

    </PageHeader>
    <PageContent class="dark bg-slate-800">
        <Listing :data="rooms" :base-url="route('rooms.index')" data-key="rooms" class="dark bg-slate-800">
            <template #actions>
                <div class="w-full grid grid-cols-4">
                    <Multiselect v-model="filtersForm.chat" name="chat" label="Chat" label-class="text-white"
                        :options="chats" mode="single" class="mr-5" :can-clear="true" :can-deselect="true" />
                    <Multiselect :options="genderFilter" name="gender" label="Gender" label-class="text-white"
                        mode="single" v-model="filtersForm.gender" :can-clear="true" :can-deselect="true" />
                    <Checkbox v-model="filtersForm.status" name="status" label="Show only online rooms"
                        label-class="text-white" class="ml-5" />
                    <Checkbox v-model="filtersForm.new" name="new" label="Show only new rooms"
                        label-class="text-white" />
                </div>
            </template>
            <template #tableHead>
                <ListingHeaderCell sort-by="id">ID</ListingHeaderCell>
                <ListingHeaderCell sort-by="username">Username</ListingHeaderCell>
                <ListingHeaderCell sort-by="chat">Chat</ListingHeaderCell>
                <ListingHeaderCell sort-by="gender">Gender</ListingHeaderCell>
                <ListingHeaderCell sort-by="age">Age</ListingHeaderCell>
                <ListingHeaderCell sort-by="location">Location</ListingHeaderCell>
                <ListingHeaderCell sort-by="viewers">Viewers</ListingHeaderCell>
                <ListingHeaderCell sort-by="status">Status</ListingHeaderCell>
                <ListingHeaderCell sort-by="new">New</ListingHeaderCell>
                <ListingHeaderCell sort-by="language">Language</ListingHeaderCell>
                <ListingHeaderCell>Likes</ListingHeaderCell>
                <ListingHeaderCell>Followers</ListingHeaderCell>
                <ListingHeaderCell>First seen</ListingHeaderCell>
                <ListingHeaderCell>Last seen</ListingHeaderCell>
                <ListingHeaderCell class="border-r border-primary-400">Actions</ListingHeaderCell>
            </template>
            <template #tableRow="{ item, action }: any">
                <ListingDataCell>
                    {{ item.id }}
                </ListingDataCell>
                <ListingDataCell>{{ item.username }}</ListingDataCell>
                <ListingDataCell>{{ chats[item.chat] }}</ListingDataCell>
                <ListingDataCell>{{ genders(item.gender) }}</ListingDataCell>
                <ListingDataCell>{{ item.age ?? '-' }}</ListingDataCell>
                <ListingDataCell>{{ item.location }} {{ item.flag ? '-' : '' }} <span
                        :class="`fi fi-${item.flag}`"></span> </ListingDataCell>
                <ListingDataCell>{{ item.viewers }}</ListingDataCell>
                <ListingDataCell>{{ item.status === 0 ? 'offline' : statuses[item.status] }}</ListingDataCell>
                <ListingDataCell>{{ item.new }}</ListingDataCell>
                <ListingDataCell>{{ item.language }}</ListingDataCell>
                <ListingDataCell>{{ item.likes }}</ListingDataCell>
                <ListingDataCell>{{ item.followers }}</ListingDataCell>
                <ListingDataCell>{{ item.first_seen ? dayjs(item.first_seen).format("D.M.YYYY") : '-' }}
                </ListingDataCell>
                <ListingDataCell>{{ item.last_seen ? dayjs(item.last_seen).format("D.M.YYYY") : '-' }}</ListingDataCell>
                <ListingDataCell style="border-right: 1px solid #818cf8;">
                    <div class="flex items-center justify-end gap-3">
                        <IconButton :icon="EyeIcon" @click="openShowRoomModal(item)" />
                        <IconButton :as="Link" :href="route('rooms.edit', item)" variant="ghost" color="white"
                            :icon="PencilSquareIcon" class="bg-primary-500" size="sm" />

                        <Modal type="danger">
                            <template #trigger="{ setIsOpen }">
                                <IconButton @click="() => setIsOpen(true)" color="danger" variant="solid"
                                    :icon="TrashIcon" size="sm" />
                            </template>

                            <template #title>
                                {{ $t("mycustomadmin", "Delete Client") }}
                            </template>
                            <template #content>
                                {{
                                    $t(
                                        `Are you sure you want to delete selected Client? All data will be permanently removed
                                from our servers forever.This action cannot be undone.`
                                    )
                                }}
                            </template>

                            <template #buttons="{ setIsOpen }">
                                <Button @click.prevent="() => {
                                    action('delete', route('rooms.destroy', item), {
                                        onFinish: () => setIsOpen(false),
                                    });
                                }
                                    " color="danger">
                                    {{ $t("mycustomadmin", "Delete") }}
                                </Button>
                                <Button @click.prevent="() => setIsOpen()" color="gray" variant="outline">
                                    {{ $t("mycustomadmin", "Cancel") }}
                                </Button>
                            </template>
                        </Modal>
                    </div>
                </ListingDataCell>
            </template>
        </Listing>
        <ShowRoom :open-modal="showRoomModal" :room="showRoom" :chats="chats" @toggleModal="closeShowRoomModal" />
    </PageContent>
</template>

<script setup lang="ts">
import PageHeader from "@/components/PageHeader.vue";
import Listing from "@/components/Listing/Listing.vue";
import ListingHeaderCell from "@/components/Listing/ListingHeaderCell.vue";
import { PaginatedCollection } from "@/types/pagination";
import { Rooms } from "@/Pages/Roles/types";
import PageContent from "@/components/PageContent.vue";
import ListingDataCell from "@/components/Listing/ListingDataCell.vue";
import {
    IconButton,
    Button,
    Modal,
    Multiselect,
    Checkbox,
} from "@/components";
// import "../../node_modules/flag-icons/css/flag-icons.min.css";
import { Link, usePage } from "@inertiajs/vue3";
import dayjs from "dayjs";
import { PencilSquareIcon, TrashIcon, EyeIcon } from "@heroicons/vue/20/solid";
import { ref, computed } from "vue";
import ShowRoom from "@/Pages/Rooms/ShowRoom.vue";
import { useListingFilters } from "@/hooks/useListingFilters";
import { PageProps } from "@/types/page";

interface Props {
    rooms: PaginatedCollection<Rooms>,
    chats: Object,
    statuses: Object,
}

defineProps<Props>();

const { filtersForm, resetFilters, activeFiltersCount } = useListingFilters(
    "/rooms",
    {
        chat: (usePage().props as PageProps).filter?.chat ?? null,
        gender: (usePage().props as PageProps).filter?.gender ?? null,
        status: (usePage().props as PageProps).filter?.status ?? null,
        new: (usePage().props as PageProps).filter?.new ?? null,
    }
)

const showRoomModal = ref(false);
const showRoom = ref({});

const openShowRoomModal = (room: any) => {
    showRoom.value = room;
    showRoomModal.value = true;
}

const closeShowRoomModal = () => {
    showRoomModal.value = false;
}

const genders = (gender: string) => {
    switch (gender) {
        case "m":
        case "male":
            gender = "Male";
            break;
        case "f":
        case "female":
            gender = "Female";
            break;
        case "c":
        case "couple":
            gender = "Couple";
            break;
        case "t":
        case "trans":
        case "transgender":
            gender = "Trans";
            break;
    }
    return gender;
};
const genderFilter = computed(() => [
    'Female', 'Male', 'Couple', 'Trans',
]);
const languages = computed(() => [
    'English', 'Spanish', 'Russian', 'French', 'German', 'Italian', 'Dutch', 'Portuguese', 'Other',
]);
const bodyTypes = computed(() => [
    'Petite', 'Slim', 'Athletic', 'Average', 'Curvy', 'Muscular', 'BBW', 'Other'
]);
const ethnicity = computed(() => [
    'Arabian', 'Asian', 'Black/Ebony', 'Indian', 'Hispanic', 'Middle Eastern', 'White', 'Other'
]);
const eye_colors = computed(() => [
    'Black', 'Brown', 'Blue', 'Green', 'Hazel', 'Gray', 'Other',
]);
const hair_colors = computed(() => [
    'black', 'brown', 'Red', 'Blonde', 'Other'
]);
const hair_length = computed(() => [
    'Bold', 'Short', 'Shoulder', 'Long', 'Other'
]);
const bustPenisSize = computed(() => [
    'Tiny', 'Small', 'Average', 'Big', 'Huge', 'Other'
]);
const pubicHair = computed(() => [
    'Shaved', 'Trimmed', 'Hairy', 'Other'
]);
const sexOrientation = computed(() => [
    'Straight', 'Bi-curious', 'Bisexual', 'Gay/Lesbian', 'Other'
])
</script>
