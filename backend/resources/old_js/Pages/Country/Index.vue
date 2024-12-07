<template>
    <LayoutAuthenticated>
        <Head title="Country" />
        <SectionMain>
            <SectionTitleLineWithButton :icon="mdiTableBorder" title="Countries" :has-cog="false"/>
            <CardBox class="mb-6" has-table>
                <table>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Shortcut</th>
                        <th>Flag</th>
                        <th />
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="country in countries.data">
                        <td>{{ country.id }}</td>
                        <td>{{ country.name}}</td>
                        <td>{{ country.flag }}</td>
                        <td><span :class="`fi fi-${country.flag}`"></span></td>
                        <td>
                            <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                <BaseButton color="info" :icon="mdiEye" small @click="isModalActive = true" />
                                <BaseButton color="info" :icon="mdiPencil" small />
                                <BaseButton
                                    color="danger"
                                    :icon="mdiTrashCan"
                                    small
                                    @click="isModalDangerActive = true"
                                />
                            </BaseButtons>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <Pagination :data="countries" :centered="true" />
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>

<script setup>
import {Head} from '@inertiajs/vue3'
// import {defineProps} from "vue";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import BaseButton from "@/Components/BaseButton.vue";
import "/node_modules/flag-icons/css/flag-icons.min.css";
import SectionMain from "@/Components/SectionMain.vue";
import CardBox from "@/Components/CardBox.vue";
import {mdiEye, mdiTrashCan, mdiPencil, mdiTableBorder} from "@mdi/js";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    countries: String,
})

</script>

