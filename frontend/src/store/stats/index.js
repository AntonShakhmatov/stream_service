import axios from "axios";
const baseUrl = import.meta.env.VITE_APP_API_URL;

const state = {
    statsRooms: []
}

const getters = {
    getStatsRooms: state => {
        return state.statsRooms;
    }
}
const actions = {
    async fetchStatsRooms({commit}, statsRoom, page = 1) {
        const {data} = await axios.get(`${baseUrl}/api/stats/${statsRoom}?page=${page}`);
        console.log(data);
        commit('setStatsRooms', data);
    }
}
const mutations = {
    setStatsRooms(state, val) {
        state.statsRooms = val;
    }
}


const stats = {
    state,
    getters,
    actions,
    mutations
};

export default stats;
