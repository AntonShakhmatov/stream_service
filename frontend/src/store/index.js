import { createStore } from "vuex";
import rooms from './rooms'
import filter from './filter'
import stats from "./stats";
import auth from './auth';
import search from './search';

const store = createStore({
    modules: {
        rooms,
        filter,
        stats,
        auth,
        search,
    }
});

export default store;