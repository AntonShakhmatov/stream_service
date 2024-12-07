const mutations = {
    setFollowedRooms(state, value) {
        state.followedRooms = value;
    },
    setHiddenRooms(state, val) {
        state.hiddenRooms = val;
    },
    setLikedRooms(state, val) {
        state.likedRooms = val;
    },
    setNotificationsRooms(state, val) {
        state.notificationsRooms = val;
    },
    setRooms(state, value) {
        state.rooms = value;
    },
    setTopRatedRooms(state, val) {
        state.topRatedRooms = val;
    },
    setRoomVideo(state, val) {
        state.roomVideo = val;
    },
    setProfileRoom(state, val) {
        state.profileRoom = val;
    },
    setProfileRoomPhotos(state, val) {
        state.profileRoomPhotos = val;
    },
    setProfileRoomStats(state, val) {
        state.profileRoomStats = val;
    },
    setRoom(state, val) {
        state.room = val;
    },
    setProfileOnlineTimes(state, val) {
        state.profileOnlineTimes = val;
    },
    setRoomModal(state, val) {
        state.roomModal = val;
    },
    setFilterQuery(state, val) {
        state.filterQuery = val;
    },
    setAllRooms(state, val) {
        state.all_rooms = val;
    },
    setAllOnlineRooms(state, val) {
        state.online_rooms = val;
    },
    setTopRatedRoomIds(state, val) {
        state.topRatedRoomIds = val;
    },
    setTrendingRooms(state, val) {
        state.trendingRooms = val;
    },
    setNotesModal(state, val) {
        state.notesModal = val;
    },
    setOpenNotesModal(state, val) {
        state.openNotesModal = val;
    },
    setLastVisitedRooms(state, val) {
        state.lastVisitedRooms = val;
    }
}

export default mutations;