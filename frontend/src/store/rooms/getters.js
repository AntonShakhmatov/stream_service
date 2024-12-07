const getters = {
    getRooms: state => {
        return state.rooms;
    },
    getTopRatedRooms: state => {
        return state.topRatedRooms;
    },
    getRoomVideo: state => {
        return state.roomVideo;
    },
    getProfileRoom: state => {
        return state.profileRoom;
    },
    getProfileRoomPhotos: state => {
        return state.profileRoomPhotos;
    },
    getProfileRoomStats: state => {
        return state.profileRoomStats;
    },
    getRoom: state => {
        return state.room;
    },
    getProfileOnlineTimes: state => {
        return state.profileOnlineTimes;
    },
    getRoomModal: state => {
        return state.roomModal;
    },
    getFilterQuery: state => {
        return state.filterQuery;
    },
    getAllRooms: state => {
        return state.all_rooms;
    },
    getAllOnlineRooms: state => {
        return state.online_rooms;
    },
    getTopRatedRoomIds: state => {
        return state.topRatedRoomIds;
    },
    getTrendingRooms: state => {
        return state.trendingRooms;
    },
    getNotesModal: state => {
        return state.notesModal;
    },
    getOpenNotesModal: state => {
        return state.openNotesModal;
    },
    getLastVisitedRooms: state => {
        return state.lastVisitedRooms;
    },
    getChats: state => {
        return state.chats;
    },
    getStatuses: state => {
        return state.statuses;
    }
}

export default getters;