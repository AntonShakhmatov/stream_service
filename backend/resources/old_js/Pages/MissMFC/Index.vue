<template>
    <LayoutAuthenticated>
        <Head title="Miss MFC" />
        <SectionMain>
            <SectionTitleLineWithButton title="Miss MFC" >
                <BaseButton route-name="mfcstats-miss.create" label="Upload new data" color="black"/>
            </SectionTitleLineWithButton>

            <CardBoxModal v-model="isModalDangerActive" title="Naozaj si prajete túto položku vymazať ?" button="danger" has-cancel @confirm="deleteConfirm" @cancel="deleteItem = {}">
                <h1>Prajete si vymazať miss mfc s dátumom {{ deleteItem?.date_formated }} ?</h1>
            </CardBoxModal>

            <CardBox class="mb-6" has-table>
                <table>
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Created date</th>
                        <th>Last updated date</th>
                        <th>Archived</th>
                        <th />
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in data">
                            <td>{{ item.date_formated }}</td>
                            <td>{{ item.created_at }}</td>
                            <td>{{ item.updated_at }}</td>
                            <td>{{ item.archived_at }}</td>
                            <td>
                                <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                    <BaseButton color="info" :icon="item.archived_at === 'Archived' ? mdiArchiveCancel : mdiArchive" small :href="route('mfcstats-miss.archive', item.date)" />
                                    <BaseButton
                                        color="danger"
                                        :icon="mdiTrashCan"
                                        small
                                        @click="openDeleteModal(item)"
                                    />
                                </BaseButtons>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
import { mdiTrashCan, mdiArchive, mdiArchiveCancel} from "@mdi/js";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import CardBoxModal from "@/Components/CardBoxModal.vue";
import { router } from '@inertiajs/vue3'


const props = defineProps({
    data: Object,
});

const isModalDangerActive = ref(false);
const deleteItem = ref({});

const deleteConfirm = () => {
        const url = route('mfcstats-miss.destroy');
        router.visit(url, {
            method: 'delete',
            data: {
                date: deleteItem.value?.date
            },
        }, {
            preserveState: true,
            preserveScroll: true,
        });
        deleteItem.value = {};
}

const openDeleteModal = (item) => {
    isModalDangerActive.value = true;
    deleteItem.value = item;
}

</script>

