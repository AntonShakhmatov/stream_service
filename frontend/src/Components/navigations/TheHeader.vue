<template>
  <div>
      <div class="white-block fixed top-0 w-screen h-[24px] bg-white my-container z-50 flex justify-between !pr-[5rem]">
          <div>
              <div v-show="parseInt(roomsCount) !== 0">
                  <span class="live-rooms">{{ roomsCount.toLocaleString("en-US") }} cams live</span>
                  <span> out of {{ allRooms.toLocaleString("en-US") }}</span>
              </div>
          </div>
          <div class="social-icons">
              <a href="https://instagram.com/" target="_blank">
                  <font-awesome-icon :icon="['fab', 'instagram']" style="color: #000000;" class="pr-[16px]" />
              </a>
              <a href="https://facebook.com/" target="_blank">
                  <font-awesome-icon :icon="['fab', 'facebook']" style="color: #000000;" class="pr-[16px]" />
              </a>
              <a href="https://twitter.com/" target="_blank">
                  <font-awesome-icon :icon="['fab', 'twitter']" style="color: #000000;" />
              </a>
          </div>
      </div>
      <TheNavigation :expanded="expanded" />
      <header
      class="px-4 py-2 fixed top-[24px] w-screen flex items-center gap-5 bg-secondary-color text-white shadow-sm z-50 my-container !pr-[5rem]"
    >
        <font-awesome-icon
            :icon="['fass', 'bars']"
            class="text-2xl inline-block cursor-pointer"
            @click="expanded = !expanded"
        />
      <div class="flex w-full items-center justify-between">
        <a
          href="/"
          class="inline-block w-56 h-12 bg-contain bg-no-repeat bg-logo cursor-pointer mb-3 md:mb-0"
        >
            <img src="@/assets/images/logo.png" alt="Mycamstars.com">
        </a>
        <SearchBar />
        <div v-if="!user?.name" class="md:hidden sm:hidden lg:flex">
          <router-link
            :to="{name: 'register'}"
            :key="$route.fullPath"
            class="hidden sm:inline-block uppercase md:mr-0 lg:mr-5 !bg-transparent"
          >
            Create account
          </router-link>
          <router-link
            to="/login"
            class="hidden sm:inline-block uppercase !bg-transparent"
          >
            Login
          </router-link>
        </div>
        <div v-else-if="false">
          <router-link to="/admin" class="hidden sm:inline-block uppercase !bg-transparent">
            ADMIN
          </router-link>
        </div>
        <div v-else-if="user?.name">
          <button class="hidden sm:inline-block uppercase !bg-transparent" @click="logout">
            Log out
          </button>
        </div>
      </div>
    </header>
  </div>
</template>

<script>
import TheNavigation from "@/components/navigations/TheNavigation.vue";
import SearchBar from "@/components/navigations/SearchBar.vue"
import {mapMutations, mapGetters, mapActions} from "vuex";
import auth from '@/store/auth/auth';
import axios from "axios";
const url = import.meta.env.VITE_APP_API_URL;

export default {
    name: "TheHeader",
    data() {
        return {
            expanded: false,
            roomsCount: 0,
            allRooms: 0,
            user: [],
        }
    },
    async created() {
        if (this.$cookies.get("my_token")) {
            await this.fetchUser();
            this.user = this.getUser;
        }
        this.roomsCount = this.getAllOnlineRooms;
        this.allRooms = this.getAllRooms;
    },
    computed: {
        ...mapGetters([
            "getRooms",
            "getAllRooms",
            "getAllOnlineRooms",
        ]),
        ...mapGetters('auth', [
            "getUser",
        ])
    },
    methods: {
        ...mapMutations("auth", [
            "setUser",
            "setToken",
        ]),
        ...mapActions('auth', [
            "fetchUser",
        ]),
        hide() {
            this.expanded = false;
        },
        logout() {
            this.$cookies.remove("my_token");
        },
    },
    watch: {
        'getRooms': function () {
            this.roomsCount = this.getAllOnlineRooms;
            this.allRooms = this.getAllRooms;
        }
    },
    components: {
        TheNavigation,
        SearchBar,
    },
}
</script>
<style scoped lang="scss">
.live-rooms {
    color: #0177E5;
    font-weight: bold;
    font-size: 16px;
}
</style>

