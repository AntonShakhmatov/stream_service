import { createApp } from 'vue'
import App from './Pages/App.vue'
import router from './router'
import store from "./store";
import VueCookies from 'vue-cookies';
import dayjs from 'dayjs'


import './assets/css/tailwind.css'
import 'vue3-toastify/dist/index.css';

const app = createApp(App)

/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'

/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import {
    faHouse,
    faCircleXmark,
    faGear,
    faCommentDots,
    faStar,
    faUsers,
    faChartBar,
    faAddressBook,
    faSignInAlt,
    faUserPlus,
    faBars,
    faAngleDoubleLeft,
    faChevronDown,
    faCircle,
    faChartLine,
    faWindowRestore,
    faChevronLeft,
    faChevronRight,
    faFire,
    faEye,
    faMars,
    faVenus,
    faTransgender,
    faVenusMars,
    faTableCellsLarge,
    faTableCells,
    faTimes,
    faSortUp,
    faSortDown,
    faXmark,
    faPlus,
    faMinus,
    faFaceSadCry,
    faList,
    faTrash,
    faAngleDoubleRight,
    faThumbsUp,
    faHeart,
    faLink,
    faCircleChevronDown,
    faCircleChevronUp
} from '@fortawesome/free-solid-svg-icons';

import {
    faInstagram,
    faFacebook,
    faTwitter,
} from "@fortawesome/free-brands-svg-icons";


library.add(faHouse, faCircleXmark, faGear, faCommentDots, faStar, faUsers, faChartBar, faAddressBook, faSignInAlt, faUserPlus, faBars, faAngleDoubleLeft, faChevronDown, faCircle, faChartLine,
    faWindowRestore, faChevronLeft, faChevronRight, faFire, faEye, faMars, faVenus, faTransgender, faVenusMars, faTableCells, faTableCellsLarge, faTimes, faSortUp, faSortDown, faXmark, faPlus, faMinus, faFaceSadCry,
    faList, faTrash, faAngleDoubleRight, faHeart, faThumbsUp, faLink, faInstagram, faFacebook, faTwitter, faCircleChevronDown, faCircleChevronUp);

app.use(router);
app.use(store);
app.use(VueCookies);

app.component('font-awesome-icon', FontAwesomeIcon);

app.config.globalProperties.$dayjs = dayjs

app.mount('#app')