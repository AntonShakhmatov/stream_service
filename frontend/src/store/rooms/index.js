import getters from "./getters"
import actions from "./actions"
import mutations from "./mutations"

const state = {
    followedRooms: [],
    hiddenRooms: [],
    likedRooms: [],
    notificationsRooms: [],
    rooms: [],
    topRatedRooms: [],
    roomVideo: [],
    profileRoom: [],
    profileRoomPhotos: [],
    profileRoomStats: [],
    room: [],
    profileOnlineTimes: [],
    roomModal: [],
    filterQuery: "",
    all_rooms: 0,
    online_rooms: 0,
    topRatedRoomIds: [],
    trendingRooms: [],
    notesModal: [],
    openNotesModal: false,
    lastVisitedRooms: [],
    statuses: [{
        1: 'free chat',
        2: 'group show',
        3: 'private chat',
        4: 'club show',
        5: 'away',
        6: 'true private',
    }],
    chats: [{
        1: 'chaturbate',
        2: 'myfreecams',
        3: 'bongacams',
        4: 'camsoda',
        5: 'cam4',
        6: 'stripchat'
    }],
}


const rooms = {
    state,
    getters,
    actions,
    mutations
};

export default rooms;