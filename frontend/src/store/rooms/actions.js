import axios from "axios";
const baseUrl = import.meta.env.VITE_APP_API_URL;

const actions = {
    async fetchRooms({commit, state}, $page) {
        const filter = parseFilter($page.filter);
        const {data} = await axios.get(`${baseUrl}/api/rooms?page=${$page.page}${filter}`);
        commit('setRooms', data.rooms);
        commit('setFilterQuery', filter);
        commit('setAllRooms', data.count_all_rooms);
        commit('setAllOnlineRooms', data.count_all_online);
    },
    async fetchTopRatedRooms({commit}) {
        const {data} = await axios.get(`${baseUrl}/api/top-rated-rooms`);
        let topRatedRoomsIds = [];
        data.map(item => {
            topRatedRoomsIds.push(item._id);
        });
        commit('setTopRatedRooms', data);
        commit('setTopRatedRoomIds', topRatedRoomsIds);
    },
    async fetchTrendingRooms({commit}) {
        const {data} = await axios.get(`${baseUrl}/api/trending-rooms`);
        commit('setTrendingRooms', data);
    },
    async fetchProfileRoomPhotos({commit, state}) {
        const {data} = await axios.get(`${baseUrl}/api/room-photos/${state.profileRoom._id}`);
        commit('setProfileRoomPhotos', data);
    },
    async fetchProfileRoomStats({commit, state}, days = 7) {
        const {data} = await axios.get(`${baseUrl}/api/rooms/${state.profileRoom._id}/stats?days=${days}`);
        commit('setProfileRoomStats', data);
    },
    async fetchProfileRoomOnlineTimes({commit, state}) {
        const {data} = await axios.get(`${baseUrl}/api/rooms/${state.profileRoom._id}/online-times`);
        console.log(data);
        commit('setProfileOnlineTimes', data.data);
    },
    async fetchRoom({commit}, roomId) {
        const {data} = await axios.get(`${baseUrl}/api/rooms/${roomId}`);
        commit('setRoom', data);
    },
    async fetchLastVisitedRooms({commit}) {
        const {data} = await axios.get(`${baseUrl}/api/last-visited-rooms?identify=${localStorage.getItem("localIdentify")}`);
        commit('setLastVisitedRooms', data);
    }
}
const parseFilter = (val) =>  {
    let query = '';
    val.ages.forEach(age => {
        query = query+`&filter[ages][]=${age}`;
    });
    val.locations.forEach(location => {
        query = query+`&filter[location][]=${location}`;
    });
    val.genders.forEach(gender => {
        query = query+`&filter[genders][]=${gender}`;
    });
    val.chats.forEach(chat => {
        query = query+`&filter[chats][]=${chat}`;
    });
    val.statuses.forEach(status  => {
        query = query+`&filter[statuses][]=${status}`;
    });
    val.body_types.forEach(body_type => {
        query = query+`&filter[body_types][]=${body_type}`;
    });
    val.ethnicity.forEach(ethnicity => {
        query = query+`&filter[ethnicity][]=${ethnicity}`;
    });
    val.eye_colors.forEach(eye_colors => {
        query = query+`&filter[eye_colors][]=${eye_colors}`;
    });
    val.hair_color.forEach(hair_color => {
        query = query+`&filter[hair_color][]=${hair_color}`;
    });
    val.hair_length.forEach(hair_length => {
        query = query+`&filter[hair_length][]=${hair_length}`;
    });
    val.height.forEach(height => {
        query = query+`&filter[heights][]=${height}`;
    });
    val.language.forEach(language => {
        query = query+`&filter[language][]=${language}`;
    });
    val.pb_size.forEach(pb_size => {
        query = query+`&filter[pb_size][]=${pb_size}`;
    });
    val.pubic_hair.forEach(pubic_hair => {
        query = query+`&filter[pubic_hair][]=${pubic_hair}`;
    });
    val.sex_orientation.forEach(sex_orientation => {
        query = query+`&filter[sex_orientation][]=${sex_orientation}`;
    });
    val.weight.forEach(weight => {
        query = query+`&filter[weight][]=${weight}`;
    });
    val.tag.forEach(tag => {
        query = query+`&filter[tag][]=${tag}`;
    });
    if (val.showJustHDRooms) {
        query = query+'&filter[showJustHDRooms]=true';
    }
    if (val.showJustNewModels) {
        query = query+'&filter[showJustNewModels]=true';
    }

    return query;
}


export default actions;