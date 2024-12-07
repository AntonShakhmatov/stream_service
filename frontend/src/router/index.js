import { createRouter, createWebHistory } from 'vue-router'
import MainPage from "@/views/MainPage.vue"
import Stats from "@/views/Stats.vue";
import Profile from "@/views/Profile.vue";
import Search from "@/views/Search.vue";
import Login from '@/views/Login.vue';
import Register from '@/views/Register.vue';
import FollowedRooms from "@/views/FollowedRooms.vue";
import HiddenRooms from "@/views/HiddenRooms.vue";
import RoomPreview from "@/views/RoomPreview.vue";
import LikedRooms from "@/views/LikedRooms.vue";
import TagsFilter from "@/views/Tags.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: MainPage
    },
    {
      path: '/profile/:username/:chat/:roomId',
      name: 'profile',
      component: Profile,
    },
    {
      path: '/stats/:room',
      name: 'stats',
      component: Stats
    },
    {
      path: '/search/:text',
      name: 'search',
      component: Search,
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
    },
    {
      path: '/register',
      name: 'register',
      component: Register,
    },
    {
      path: '/followed-rooms',
      name: 'followed-rooms',
      component: FollowedRooms,
    },
    {
      path: '/hidden-rooms',
      name: 'hidden-rooms',
      component: HiddenRooms,
    },
    {
      path: '/liked-rooms',
      name: 'lied-rooms',
      component: LikedRooms,
    },
    {
      path: '/room-preview/:username/:chat/:roomId',
      name: 'room-preview',
      component: RoomPreview,
    },
    {
      path: '/tags',
      name: 'tags',
      component: TagsFilter
    }
  ]
})

export default router
