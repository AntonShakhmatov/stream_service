<template>
<PageHeader title="Miss MFC">
    <Button
        @click.prevent="uploadModal = true"
    >
        <!-- {{ $t("mycustomadmin", "Upload Miss MFC") }} -->
        {{ $t("Upload Miss MFC") }}
    </Button>
</PageHeader>
<PageContent>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-slate-800 text-white border border-primary-400">
        <tr>
            <ListingHeaderCell>Date</ListingHeaderCell>
            <ListingHeaderCell>Created date</ListingHeaderCell>
            <ListingHeaderCell>Last updated date</ListingHeaderCell>
            <ListingHeaderCell>Archived</ListingHeaderCell>
            <ListingHeaderCell class="text-center">Actions</ListingHeaderCell>
        </tr>
        </thead>
        <tbody class="divide-y divide-primary-400 bg-slate-800 text-white">
        <tr v-for="item in missMfc"  style="border-bottom: 1px solid #818cf8;">
            <ListingDataCell style="border-left: 1px solid #818cf8;">{{ item.date_formated }}</ListingDataCell>
            <ListingDataCell>{{ item.created_at }}</ListingDataCell>
            <ListingDataCell>{{ item.updated_at }}</ListingDataCell>
            <ListingDataCell>{{ item.archived_at }}</ListingDataCell>
            <ListingDataCell  style="border-right: 1px solid #818cf8;">
                <BaseButtons type="justify-start lg:justify-end" no-wrap>
                    <IconButton
                        :icon="item.archived_at === 'Archived' ? ArchiveBoxArrowDownIcon : ArchiveBoxIcon"
                        :href="route('mfcstats-miss.archive', item.date)"
                        :as="Link"
                        :title="item.archived_at === 'Archived' ? 'Unarchive' : 'Archive'"
                    />

                    <IconButton
                        :icon="TrashIcon"
                        @click="openDeleteModal(item)"
                        color="danger"
                        title="Delete"
                    />
                </BaseButtons>
            </ListingDataCell>
        </tr>
        </tbody>
    </table>
    <Modal type="info" :open="uploadModal" :external-open="true">
        <template #title>
            <h1>Upload Miss MFC</h1>
        </template>
        <template #content>
            <form @submit.prevent="submit">
                <DatePicker v-model="form.date"  name="date"/>
                <FormFilePicker
                    class="mt-2"
                    v-model="form.miss_mfc"
                    :icon="mdiUpload"
                    label="Select upload file"
                />
            </form>
        </template>

        <template #buttons="{ setIsOpen }">
            <Button
                @click.prevent="submit"
                color="info"
            >
                <!-- {{ $t("mycustomadmin", "Upload") }} -->
                {{ $t("Upload") }}
            </Button>
            <Button
                @click.prevent="uploadModal = false"
                color="gray"
                variant="outline"
            >
                <!-- {{ $t("mycustomadmin", "Cancel") }} -->
                {{ $t("Cancel") }}
            </Button>
        </template>
    </Modal>
    <Modal type="danger" :open="isModalDangerActive" :external-open="true">
        <template #title>
            <h1>Naozaj si prajete túto položku vymazať ?</h1>
        </template>
        <template #content>
            <h1>Prajete si vymazať miss mfc s dátumom {{ deleteItem?.date_formated }} ?</h1>
        </template>

        <template #buttons="{ setIsOpen }">
            <Button
                @click.prevent="deleteConfirm"
                color="info"
            >
                <!-- {{ $t("mycustomadmin", "Delete") }} -->
                {{ $t("Delete") }}
            </Button>
            <Button
                @click.prevent="() => {
                    deleteItem = {};
                    isModalDangerActive = false;
                    }"
                color="gray"
                variant="outline"
            >
                <!-- {{ $t("mycustomadmin", "Cancel") }} -->
                {{ $t("Cancel") }}
            </Button>
        </template>
    </Modal>
</PageContent>
</template>

<script setup lang="ts">
import {
    PageHeader,
    PageContent,
    Button,
    DatePicker,
    IconButton,
    ListingHeaderCell,
    ListingDataCell
} from "@/components";
import CardBox from "@/components/Theme/CardBox.vue";
import BaseButtons from "@/components/Theme/BaseButtons.vue";
import Modal from "@/components/Modal.vue";
import {ref} from "vue";
import FormFilePicker from "@/components/Theme/FormFilePicker.vue";
import {router, Link} from "@inertiajs/vue3";
import {ArchiveBoxIcon, ArchiveBoxArrowDownIcon, TrashIcon} from "@heroicons/vue/20/solid";
import {mdiUpload} from "@mdi/js";

interface Props {
    missMfc: Object,
}

const form = {
    date: "",
    miss_mfc: null,
}

const uploadModal = ref(false);

const submit = () => {
    router.post(route('mfcstats-miss.store'), form);
    uploadModal.value = false;
}

const isModalDangerActive = ref(false);
const deleteItem = ref({});

const deleteConfirm = () => {
    const url = route('mfcstats-miss.destroy');
    router.visit(url, {
        method: 'delete',
        data: {
            date: deleteItem.value?.date
        },
        preserveScroll: true,
        preserveState: true,
    });
    isModalDangerActive.value = false;
    deleteItem.value = {};
}

const openDeleteModal = (item: object) => {
    isModalDangerActive.value = true;
    deleteItem.value = item;
}


defineProps<Props>()
</script>


