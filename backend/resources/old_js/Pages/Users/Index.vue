<template>
    <LayoutAuthenticated>
        <SectionMain>
            <SectionTitleLineWithButton title="Users" :has-cog="false">
                <BaseButton route-name="users.create" label="Create new user" color="black"/>
            </SectionTitleLineWithButton>

            <CardBoxModal v-model="isModalDangerActive" title="Naozaj si prajete túto položku vymazať ?" button="danger" has-cancel @confirm="deleteConfirm" @cancel="deleteItem = {}">
                <h1>Naozaj si prajete vymazať používateľa {{ deleteUser?.name }}?</h1>
            </CardBoxModal>


            <CardBox>
                <table>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users.data" :key="user.id">
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>
                                <BaseButtons  type="justify-start lg:justify-end" no-wrap>
                                    <BaseButton color="info" :icon="mdiPencil" small :href="route('users.edit',user)" />
                                    <BaseButton
                                        color="danger"
                                        :icon="mdiTrashCan"
                                        small
                                        @click="openDeleteModal(user)"
                                    />
                                </BaseButtons>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination :data="users" />
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>

<script setup>

import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import SectionMain from "@/Components/SectionMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import CardBox from "@/Components/CardBox.vue";
import {ref} from "vue";
import Pagination from "@/Components/Pagination.vue";
import BaseButton from '@/Components/BaseButton.vue'
import BaseButtons from "@/Components/BaseButtons.vue";
import CardBoxModal from "@/Components/CardBoxModal.vue";
import {router} from "@inertiajs/vue3";
import {mdiPencil, mdiTrashCan} from "@mdi/js";

const props = defineProps({
    users: Object,
});

const deleteUser = ref({});

const isModalDangerActive = ref(false);

const deleteConfirm = () => {
    const url = route('users.destroy', deleteUser.value.id);
    router.visit(url, {
        method: 'delete',
    }, {
        preserveState: true,
        preserveScroll: true,
    });
    deleteUser.value = {};
}

const openDeleteModal = (user) => {
    isModalDangerActive.value = true;
    deleteUser.value = user;
}



</script>


