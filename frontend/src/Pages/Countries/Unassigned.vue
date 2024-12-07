<template>
    <PageHeader title="Unassigned countries" />
    <PageContent>
        <Listing :data="unassigned" data-key="unassigned" :base-url="route('country.unassigned-locations')">
            <template #bulkActions="{bulkAction, selectedItems}">
                <Modal type="danger">
                    <template #trigger="{ setIsOpen }">
                        <Button
                            @click="() => setIsOpen(true)"
                            color="gray"
                            variant="outline"
                            size="sm"
                        >
                            Assign country
                        </Button>
                    </template>

                    <template #title>
                        Assign unassigned countries
                    </template>
                    <template #content>
                        <Multiselect
                            :options="countries"
                            v-model="selectedCountry"
                            name="countries"
                            options-label="value"
                            options-value-prop="key"
                            mode="single"
                        />
                    </template>

                    <template #buttons="{ setIsOpen }">
                        <Button
                            @click.prevent="
                            () => {
                                action('post',
                                route('country.assing-unassigned'),
                                {
                                    selectedItems: selectedItems,
                                    country_id: selectedCountry,
                                });
                                setIsOpen()
                            }"
                            color="info"
                        >
                            <!-- {{ $t("mycustomadmin", "Assign") }} -->
                            {{ $t("Assign") }}
                        </Button>
                        <Button
                            @click.prevent="() => setIsOpen()"
                            color="gray"
                            variant="outline"
                        >
                            <!-- {{ $t("mycustomadmin", "Cancel") }} -->
                            {{ $t("Cancel") }}
                        </Button>
                    </template>
                </Modal>
            </template>
            <template #tableHead>
                <ListingHeaderCell sort-by="id">Id</ListingHeaderCell>
                <ListingHeaderCell class="border-r border-primary-400" sort-by="location">Location</ListingHeaderCell>
            </template>
            <template #tableRow="{item, action}: any">
                <ListingDataCell>{{ item.id }}</ListingDataCell>
                <ListingDataCell style="border-right-width: 1px;border-right-color: #818cf8;">{{ item.location }}</ListingDataCell>
            </template>
        </Listing>
    </PageContent>
</template>

<script setup lang="ts">
import {PaginatedCollection} from "@/types/pagination";
import {Unassigned} from "@/Pages/Countries/types";
import {
    PageContent,
    PageHeader,
    Listing,
    ListingDataCell,
    ListingHeaderCell,
    Multiselect,
    Modal,
    Button,
} from "@/components";
import {ref} from "vue";
import {useAction} from "@/hooks/useAction";

interface Props {
    unassigned: PaginatedCollection<Unassigned>,
    countries: any[],
}

const selectedCountry = ref([]);

defineProps<Props>();

const {action} = useAction();

</script>
