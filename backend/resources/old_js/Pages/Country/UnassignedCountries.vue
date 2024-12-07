<template>
    <LayoutAuthenticated>
        <SectionMain>
            <SectionTitleLineWithButton title="Unassigned locations" :has-cog="false" />
            <CardBox>
                <table>
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="location in unassigned.data">
                            <td>{{ location.id }}</td>
                            <td>{{ location.location }}</td>
                            <td>

                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination :data="unassigned" />
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>

<script setup>
// import {defineProps} from "vue";
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
import SectionMain from "@/Components/SectionMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import CardBox from "@/Components/CardBox.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    unassigned: Object,
})
</script>

<style scoped>

</style>
