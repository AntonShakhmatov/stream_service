import axios from "axios";
const baseUrl = import.meta.env.VITE_APP_API_URL;

const state = {
    searchOptions: {
        userNames: true,
        topics: true,
        tags: true,
        offline: false,
        chaturbate: true,
        myfreecams: true,
        bongacams: true,
        camsoda: true,
        cam4: true,
        stripchat: true,
        searchText: "",
    },
    searchRooms: [],
    refreshSearchPage: false,
}

const getters = {
    getSearchOptions: state => {
        return state.searchOptions;
    },
    getSearchRooms: state => {
        return state.searchRooms;
    },
    getRefreshSearchPage: state => {
        return state.refreshSearchPage;
    }
}

const actions = {
    async fetchSearchTags({commit, state, getters}, search) {
        const {data} = await axios.post(`${baseUrl}/api/search/tags/${state.searchOptions.searchText}?page=${search.page}`, {
            tags: state.searchOptions.tags,
            offline:state.searchOptions.offline,
            rooms: [{
                chaturbate: state.searchOptions.chaturbate,
                myfreecams: state.searchOptions.myfreecams,
                bongacams: state.searchOptions.bongacams,
                camsoda: state.searchOptions.camsoda,
                cam4: state.searchOptions.cam4,
                stripchat: state.searchOptions.stripchat
            }],
        });
        commit('setSearchRooms', {data:data, page:'tags'});
    },
    async fetchSearchTopics({commit, state}, search) {
        const {data} = await axios.post(`${baseUrl}/api/search/topics/${state.searchOptions.searchText}?page=${search.page}`, {
            topics: state.searchOptions.topics,
            offline:state.searchOptions.offline,
            rooms: [{
                chaturbate: state.searchOptions.chaturbate,
                myfreecams: state.searchOptions.myfreecams,
                bongacams: state.searchOptions.bongacams,
                camsoda: state.searchOptions.camsoda,
                cam4: state.searchOptions.cam4,
                stripchat: state.searchOptions.stripchat
            }],
        });
        commit('setSearchRooms', {data:data, page:'topics'});
    },
    async fetchSearchUsername({commit, state}, search) {
        const {data} = await axios.post(`${baseUrl}/api/search/username/${state.searchOptions.searchText}?page=${search.page}`, {
            usernames: state.searchOptions.userNames,
            offline:state.searchOptions.offline,
            rooms: [{
                chaturbate: state.searchOptions.chaturbate,
                myfreecams: state.searchOptions.myfreecams,
                bongacams: state.searchOptions.bongacams,
                camsoda: state.searchOptions.camsoda,
                cam4: state.searchOptions.cam4,
                stripchat: state.searchOptions.stripchat
            }],
        });
        commit('setSearchRooms', {data:data, page:'username'});
    }
}

const mutations = {
    setSearchOptions(state, val) {
        state.searchOptions = val;
    },
    setSearchRooms(state, val) {
        state.searchRooms[val.page] = val.data;
    },
    setSearchText(state, val) {
        state.searchOptions.searchText = val;
    },
    setRefreshSearchPage(state, val) {
        state.refreshSearchPage = val;
    }
}

const search = {
    state,
    getters,
    actions,
    mutations
}
export default search;