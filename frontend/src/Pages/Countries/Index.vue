<template>
    <PageHeader title="Countries" />
    <PageContent>
        <Listing :data="countries" data-key="countries" :base-url="route('country.index')">
            <template #tableHead>
                <ListingHeaderCell sort-by="id">Id</ListingHeaderCell>
                <ListingHeaderCell sort-by="name">Name</ListingHeaderCell>
                <ListingHeaderCell sort-by="flag">Flag</ListingHeaderCell>
                <ListingHeaderCell class="border-r border-primary-400">Actions</ListingHeaderCell>
            </template>
            <template #tableRow="{item, action}: any">
                <ListingDataCell>{{ item.id }}</ListingDataCell>
                <ListingDataCell>{{ item.name }}</ListingDataCell>
                <ListingDataCell>{{ item.flag }}</ListingDataCell>
                <ListingDataCell style="border-right-width: 1px;border-right-color: #818cf8">

                </ListingDataCell>
            </template>
        </Listing>
    </PageContent>
</template>

<script setup lang="ts">
import {PaginatedCollection} from "@/types/pagination";
import {Countries} from "@/Pages/Countries/types";
import PageHeader from "@/components/PageHeader.vue";
import PageContent from "@/components/PageContent.vue";
import Listing from "@/components/Listing/Listing.vue";
import ListingHeaderCell from "@/components/Listing/ListingHeaderCell.vue";
import ListingDataCell from "@/components/Listing/ListingDataCell.vue";

interface Props {
    countries: PaginatedCollection<Countries>,
}

defineProps<Props>();
</script>


