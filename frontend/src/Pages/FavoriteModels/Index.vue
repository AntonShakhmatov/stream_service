<template>
    <div class="min-h-screen flex flex-col bg-slate-900">
        <PageHeader title="Favorite Models"></PageHeader>

        <PageContent class="flex-1 p-5 bg-slate-800 border border-slate-700">
            <table class="table-auto w-full text-white border-collapse border border-slate-600">
                <thead>
                    <tr class="flex">
                        <ListingHeaderCell class="p-3 border border-slate-600 text-center w-1/2">Name</ListingHeaderCell>
                        <ListingHeaderCell class="p-3 border border-slate-600 text-center w-1/2">Actions</ListingHeaderCell>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(link, index) in links" :key="link.id || index" class="flex">
                        <ListingDataCell class="p-3 border border-slate-600 w-1/2">
                            <input 
                                v-model="link.username" 
                                type="text" 
                                class="w-full bg-slate-700 text-white p-2 rounded border border-slate-500"
                                placeholder="Enter name"
                            >
                        </ListingDataCell>
                        <td class="p-3 border border-slate-600 w-1/2 flex gap-2">
                            <Button 
                                @click="saveLink(link, index)" 
                                class="bg-green-500 text-white px-3 py-1 rounded"
                            >
                                Save
                            </Button>
                            <!-- <Button 
                                v-if="link.id" 
                                @click="deleteLink(link.id)" 
                                class="bg-red-500 text-white px-3 py-1 rounded"
                            >
                                Delete
                            </Button> -->
                        </td>
                    </tr>
                </tbody>
            </table>
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
        links: Array,
    },
    data() {
        return {
            links: this.links.length >= 10
                ? this.links
                : Array.from({ length: 10 }, (_, i) => this.links[i] || { username: '', id: null }),
        };
    },
    methods: {
        saveLink(link, index) {
            if (link.username.trim() === '') {
                alert('Name cannot be empty.');
                return;
            }

            const method = link.id ? 'put' : 'post';
            const routeName = link.id ? route('favorite.update', link.id) : route('favorite.store');

            Inertia[method](routeName, { username: link.username }, {
                onSuccess: (page) => {
                    alert('Link saved successfully!');
                    // Локальное обновление данных
                    if (link.id) {
                        this.$set(this.links, index, { ...link, username: page.props.flash.message || link.username });
                    } else {
                        this.$set(this.links, index, { ...link, id: page.props.id });
                    }
                },
                onError: (err) => {
                    console.error(err);
                    alert('Failed to save the link.');
                }
            });
        },
        deleteLink(id) {
            if (confirm('Are you sure you want to delete this link?')) {
                Inertia.delete(route('favorite.destroy', id), {
                    onSuccess: () => {
                        this.links = this.links.map(link => (link.id === id ? { username: '', id: null } : link));
                    },
                });
            }
        },
    },
};
</script>
