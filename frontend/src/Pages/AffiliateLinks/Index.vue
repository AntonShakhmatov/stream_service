<template>
    <div class="min-h-screen flex flex-col bg-slate-900">
        <PageHeader title="Affiliate Links"></PageHeader>

        <PageContent class="flex-1 p-5 bg-slate-800 border border-slate-700">
            <Button @click="createLink" class="mb-5 bg-blue-500 text-white px-4 py-2 rounded">
                Create New Link
            </Button>

            <table class="table-auto w-full text-white border-collapse border border-slate-600">
                <thead>
                    <tr class="flex">
                        <ListingHeaderCell class="p-3 border border-slate-600 text-left w-1/4">Platform</ListingHeaderCell>
                        <ListingHeaderCell class="p-3 border border-slate-600 text-center w-1/2">Iframe URL</ListingHeaderCell>
                        <ListingHeaderCell class="p-3 border border-slate-600 text-right w-1/4">Actions</ListingHeaderCell>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="link in links.data" :key="link.id" class="flex">
                        <ListingDataCell class="p-3 border border-slate-600 w-1/4">{{ link.platform }}</ListingDataCell>
                        <ListingDataCell class="p-3 border border-slate-600 w-1/2">
                            <input 
                                v-model="link.url" 
                                type="text" 
                                class="w-full bg-slate-700 text-white p-2 rounded border border-slate-500"
                                placeholder="Enter URL"
                            >
                        </ListingDataCell>
                        <td class="p-3 border border-slate-600 w-1/4 flex gap-2">
                            <Button 
                                @click="editLink(link)" 
                                class="bg-green-500 text-white px-3 py-1 rounded"
                            >
                                Edit
                            </Button>
                            <Button 
                                @click="deleteLink(link.id)" 
                                class="bg-red-500 text-white px-3 py-1 rounded"
                            >
                                Delete
                            </Button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-5 flex justify-between">
                <Button 
                    v-if="links.prev_page_url" 
                    @click="changePage(links.prev_page_url)"
                    class="bg-blue-500 text-white px-4 py-2 rounded"
                >
                    Previous
                </Button>
                <Button 
                    v-if="links.next_page_url" 
                    @click="changePage(links.next_page_url)"
                    class="bg-blue-500 text-white px-4 py-2 rounded"
                >
                    Next
                </Button>
            </div>
        </PageContent>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
import PageHeader from "@/components/PageHeader.vue";
import ListingHeaderCell from "@/components/Listing/ListingHeaderCell.vue";
import PageContent from "@/components/PageContent.vue";
import ListingDataCell from "@/components/Listing/ListingDataCell.vue";
import { Button } from "@/components";

export default {
    props: {
        links: Object,
    },
    methods: {
        createLink() {
            Inertia.visit(route('aff.create'));
        },
        editLink(link) {
            Inertia.put(route('aff.edit', link.id), { url: link.url }, {
                onError: (err) => {
                    console.error(err);
                },
                onSuccess: () => {
                    alert('Link updated successfully!');
                },
            });
        },
        deleteLink(id) {
            if (confirm('Are you sure you want to delete this link?')) {
                Inertia.delete(route('aff.destroy', id));
            }
        },
        changePage(url) {
            Inertia.visit(url);
        },
    },
};
</script>
