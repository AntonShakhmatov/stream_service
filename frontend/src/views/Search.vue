<template>
   <MainLayout>
       <div class="min-h-screen flex flex-col gap-5 text-white">
           <SearchSection
               label="Model Names matching"
               :rooms="modelNames"
               page="usernames"
               v-show="options.userNames"
           />

           <SearchSection
               label="Model Tags matching"
               :rooms="modelTags"
               page="tags"
               v-show="options.tags"
           />

           <SearchSection
               label="Model Topics matching"
               :rooms="modelTopics"
               page="topics"
               v-show="options.topics"
           />
       </div>
   </MainLayout>
</template>

<script>
import SearchSection from "@/components/frontend/SearchSection.vue";
import MainLayout from "@/views/layouts/MainLayout.vue";

import {mapGetters, mapActions, mapMutations} from "vuex";


export default {
    name: "Search",
    components: {SearchSection, MainLayout},
    data() {
        return {
            searchText: "",
            modelNames: [],
            modelTags: [],
            modelTopics: [],
            options: [],
        }
    },
    async created() {
        this.setOptions();
        await this.fetchSearch();
    },
    methods: {
        ...mapActions([
            "fetchSearchTags",
            'fetchSearchTopics',
            "fetchSearchUsername",
        ]),
        ...mapMutations([
            "setSearchText",
            "setRefreshSearchPage",
        ]),
        async fetchSearch() {
            this.searchText = this.$route.params.text;
            this.setSearchText(this.searchText);

            if (this.getSearchOptions.tags) {
                await this.fetchSearchTags({page: 1});
                this.modelTags = this.getSearchRooms?.tags;
            }

            if (this.getSearchOptions.topics) {
                await this.fetchSearchTopics({page: 1});
                this.modelTopics = this.getSearchRooms?.topics;
            }

            if (this.getSearchOptions.userNames) {
                await this.fetchSearchUsername({page: 1});
                console.log(this.getSearchRooms);
                this.modelNames = this.getSearchRooms?.username;
            }
        },
        setOptions() {
            this.options = this.getSearchOptions;
        }
    },
    computed: {
        ...mapGetters([
            'getSearchRooms',
            "getSearchOptions",
            "getRefreshSearchPage",
        ])
    },
    watch: {
        'getSearchRooms.tags': function () {
            this.modelTags = this.getSearchRooms.tags;
        },
        'getSearchRooms.topics': function () {
            this.modelTopics = this.getSearchRooms.topics;
        },
        'getSearchRooms.username': function () {
            this.modelNames = this.getSearchRooms.username;
        },
        'getSearchOptions': function (newVal, oldVal) {
            this.options = this.getSearchOptions;
            this.fetchSearch();
        },
        "getRefreshSearchPage": function () {
            if (this.getRefreshSearchPage === true || this.getRefreshSearchPage === "true") {
                console.log('runned refresh page', this.getRefreshSearchPage);
                this.fetchSearch();
                this.setRefreshSearchPage(false);
            }
        }
    }
}
</script>

<style scoped>

</style>
