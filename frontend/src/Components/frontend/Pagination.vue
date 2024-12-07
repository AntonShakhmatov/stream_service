<template>
    <div class="bg-secondary-color text-white p-2">
        <span>Page</span>
        <font-awesome-icon :icon="['fas', 'chevron-left']" class="px-3 hover:cursor-pointer" @click="movePage(rooms.prev_page_url)" />
        <select v-model="page" id="page" @change="changePage" class="text-black w-[70px] px-1 filter-select">
            <option v-for="link in calculateAllPages()" :value="link.label" :data-url="link.url" v-show="parseInt(link.label)">{{ link.label }}</option>
        </select>
        <font-awesome-icon :icon="['fas', 'chevron-right']" class="px-3 hover:cursor-pointer" @click="movePage(rooms.next_page_url)"  />
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
    name: "Pagination",
    props: {
        rooms: Object,
    },
    data() {
        return {
            page: 0,
        }
    },
    created() {
        this.page = this.rooms?.current_page;
        this.calculateAllPages();
    },
    methods: {
        ...mapActions([
            'fetchRooms'
        ]),
        changePage(e) {
            if(e.target.options.selectedIndex > -1) {
                const url = e.target.options[e.target.options.selectedIndex].dataset.url;
                const $page = this.parseUrlGetPage(url);

                this.fetchRooms({page:$page[1], filter: this.getActiveFilter});

                this.$router.push(`/?page=${$page[1]}${this.getFilterQuery}`);
            }
        },
        movePage(val) {
            const $page = val.slice(-1);
            this.fetchRooms({page:$page, filter: this.getActiveFilter});
            this.$router.push(`/?page=${$page}${this.getFilterQuery}`);
        },
        getPage() {
            const page = {}
            if (page) {
                this.page = page[0];
            } else {
                this.page = 1;
            }
        },
        parseUrlGetPage(url) {
            return url.split("=");
        },
        calculateAllPages() {
            const totalPages = this.rooms?.last_page;
            const baseUrl = this.rooms?.first_page_url?.split("?");
            let list = [];

            for (let $i = 1; $i <= totalPages;$i++) {
                list.push({
                    label: $i,
                    url: `${baseUrl[0]}?page=${$i}`
                });
            }
            return list;
        }
    },
    computed: {
        ...mapGetters([
            "getActiveFilter",
            "getFilterQuery",
        ]),
    },
    watch: {
        '$page.url': function () {
            this.getPage();
        },
        'rooms': function () {
            this.page = this.rooms.current_page;
        }
    }
}
</script>

<style scoped lang="scss">
.filter-select {
    width: 60px; /* Zmenšená šírka select boxu */
    padding: 0 10px; /* Prispôsobenie vnútorného odsadenia */
    box-sizing: border-box; /* Zachovanie celkovej šírky s ohraničením a paddingom */
}
</style>
