<template>
    <div class="flex justify-center">
        <ul v-if="rooms?.links" class="flex">
            <li
                v-show="parseInt(page.label)"
                v-for="page in rooms?.links"
            >
                <button
                    @click="changePage(page.label)"
                    class="border border-black bg-black text-white py-2 px-3 my-2 mx-1 hover:bg-blue-600"
                    :class="{'bg-blue-600': rooms.current_page === parseInt(page.label)}"
                >
                    {{ page.label }}
                </button>
            </li>
        </ul>
    </div>
</template>

<script>
import {mapGetters,mapActions} from "vuex";

export default {
    name: "LinePagination",
    props: {
        rooms: Object,
        page: String
    },
    methods: {
        ...mapActions([
            "fetchSearchTags",
            "fetchSearchTopics",
            "fetchSearchUsername",
        ]),
        async changePage(label) {
            if (this.page === 'tags') {
                await this.fetchSearchTags({text: this.$route.params.text, page: label});
            }

            if (this.page === 'topics') {
                await this.fetchSearchTopics({text: this.$route.params.text, page: label});
            }

            if (this.page === 'usernames') {
                await this.fetchSearchUsername({text: this.$route.params.text, page: label});
            }
        }
    },
    computed: {
        ...mapGetters([
            "getSearchRooms"
        ])
    }

}
</script>

<style scoped>

</style>