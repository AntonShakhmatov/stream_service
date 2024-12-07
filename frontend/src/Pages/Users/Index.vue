<template>
    <PageHeader title="Users">
        <Button
            :leftIcon="ArrowDownTrayIcon"
            as="a"
            :href="route('users.create')"
        >
            <!-- {{ $t("mycustomadmin", "Create user") }} -->
            {{ $t("Create user") }}
        </Button>
    </PageHeader>
    <PageContent>
        <Listing :data="users" data-key="users">
            <template #tableHead>
                <ListingHeaderCell sort-by="id">
                    ID
                </ListingHeaderCell>
                <ListingHeaderCell sort-by="username">
                    Name
                </ListingHeaderCell>
                <ListingHeaderCell sort-by="email">
                    Email
                </ListingHeaderCell>
                <ListingHeaderCell>
                    Role
                </ListingHeaderCell>
                <ListingHeaderCell class="border-r border-primary-400">
                    Actions
                </ListingHeaderCell>
            </template>
            <template #tableRow="{item, action}: any">
                <ListingDataCell>
                    {{ item.id }}
                </ListingDataCell>
                <ListingDataCell>
                    {{ item.name }}
                </ListingDataCell>
                <ListingDataCell>
                    {{ item.email }}
                </ListingDataCell>
                <ListingDataCell>
                    {{ item.roles[0]?.name }}
                </ListingDataCell>
                <ListingDataCell style="border-right: 1px solid #818cf8;">
                    <div class="flex items-center justify-end gap-3">
                        <IconButton
                            :as="Link"
                            :href="route('users.edit', item)"
                            variant="ghost"
                            color="white"
                            :icon="PencilSquareIcon"
                            class="bg-primary-500"
                            size="sm"
                        />
                        <Modal type="danger">
                            <template #trigger="{ setIsOpen }">
                                <IconButton
                                    @click="() => setIsOpen(true)"
                                    color="danger"
                                    variant="solid"
                                    :icon="TrashIcon"
                                    size="sm"
                                />
                            </template>

                            <template #title>
                                <!-- {{ $t("mycustomadmin", "Delete user") }} -->
                                {{ $t("Delete user") }}
                            </template>
                            <template #content>
                                {{
                                    // $t(
                                    //     "mycustomadmin",
                                    //     "Are you sure you want to delete selected user? All data will be permanently removed from our servers forever. This action cannot be undone."
                                    // )
                                    $t(
                                        "Are you sure you want to delete selected user? All data will be permanently removed from our servers forever. This action cannot be undone."
                                    )
                                }}
                            </template>

                            <template #buttons="{ setIsOpen }">
                                <Button
                                    @click.prevent="
                                            () => {
                                              action('delete', route('users.destroy', item), {
                                                onFinish: () => setIsOpen(false),
                                              });
                                            }
                                          "
                                    color="danger"
                                >
                                    <!-- {{ $t("mycustomadmin", "Delete") }} -->
                                    {{ $t("Delete") }}
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
                    </div>
                </ListingDataCell>
            </template>
        </Listing>
    </PageContent>
</template>

<script setup lang="ts">
import {
    PageHeader,
    PageContent,
    Listing,
    ListingHeaderCell,
    ListingDataCell,
    IconButton,
    Modal,
    Button
} from '@/components';
import {PencilSquareIcon, TrashIcon} from "@heroicons/vue/20/solid";
import {PaginatedCollection} from "@/types/pagination";
import {Users} from "@/Pages/Users/types";

interface Props {
    users: PaginatedCollection<Users>,
}

defineProps<Props>()
</script>


