<template>
  <div class="flex flex-grow items-center justify-center gap-2 w-1/2 lg:flex-grow-0">
    <form @submit.prevent="handleSubmit" class="2xl:w-[50%] xl:w-[70%] flex items-center">
          <input
            class="block w-full py-1 pl-3 xl:pr-12 lg:pr-6 bg-bg-color rounded-sm"
            type="text"
            placeholder="Search"
            minlength="3"
            v-model="options.searchText"
          />
        <font-awesome-icon :icon="['fas', 'circle-xmark']"
                           style="color: #ffffff;"
                           @click="handleCancel"
                           :class="[
                            options.searchText?.length < 3 && 'opacity-0',
                              'relative right-12 text-lg inline-block cursor-pointer',
                            ]"
        />
      <div class="relative mr-4">
        <font-awesome-icon @click="open = !open" :icon="['fass', 'gear']" style="color: #ffffff;" class="text-lg inline-block cursor-pointer"/>
        <div v-if="open" class="absolute w-[13.5rem] p-2 top-10 -left-20 bg-secondary-color">
          <ul class="flex flex-col gap-2 search-bar">
            <li>
              <label class="text-white">
                <input
                  type="checkbox"
                  v-model="options.userNames"
                  @change="changeSearchOptions"
                />
                <span>Search in usernames</span>
              </label>
            </li>
            <li>
              <label>
                <input
                  type="checkbox"
                  v-model="options.topics"
                  @change="changeSearchOptions"
                >
                <span>Search in room topics</span>
              </label>
            </li>
            <li>
              <label>
                <input
                  type="checkbox"
                  v-model="options.tags"
                  @change="changeSearchOptions"
                />
                <span>Search in tags</span>
              </label>
            </li>
            <li>
              <label>
                <input
                  type="checkbox"
                  v-model="options.offline"
                  @change="changeSearchOptions"
                />
                <span>Search in offline rooms</span>
              </label>
            </li>
          </ul>
          <span class="block my-2 font-bold">Chats:</span>
          <ul class="flex flex-col gap-2 search-bar">
            <li>
              <label>
                <input
                  type="checkbox"
                  v-model="options.chaturbate"
                  @change="changeSearchOptions"
                />
                <span>chaturbate</span>
              </label>
            </li>
            <li>
              <label>
                <input
                  type="checkbox"
                  v-model="options.myfreecams"
                  @change="changeSearchOptions"
                />
                <span>myfreecams</span>
              </label>
            </li>
            <li>
              <label>
                <input
                  type="checkbox"
                  v-model="options.bongacams"
                  @change="changeSearchOptions"
                />
                <span>bongacams</span>
              </label>
            </li>
              <li>
                  <label>
                      <input
                          type="checkbox"
                          v-model="options.camsoda"
                          @change="changeSearchOptions"
                      />
                      <span>camsoda</span>
                  </label>
              </li>
              <li>
                  <label>
                      <input
                          type="checkbox"
                          v-model="options.cam4"
                          @change="changeSearchOptions"
                      />
                      <span>cam4</span>
                  </label>
              </li>
              <li>
                  <label>
                      <input
                          type="checkbox"
                          v-model="options.stripchat"
                          @change="changeSearchOptions"
                      />
                      <span>stripchat</span>
                  </label>
              </li>
          </ul>
        </div>
      </div>
      <SecondaryButton :disabled="loading" active @click="handleSubmit">Search</SecondaryButton>
    </form>

  </div>
</template>

<script>
import SecondaryButton from "@/components/partials/SecondaryButton.vue";
import {mapActions, mapGetters, mapMutations} from "vuex";

export default {
    name: "SearchBar",
    data() {
        return {
            searchText: '',
            loading: false,
            open: false,
            options: [],
        }
    },
    components: {
        SecondaryButton
    },
    created() {
        this.options = this.getSearchOptions;
        if (this.$route.params?.text) {
            this.searchText = this.$route.params?.text;
        }
    },
    methods: {
        methods: {
            ...mapActions([
                "fetchSearchTags",
                'fetchSearchTopics',
                "fetchSearchUsername",
            ])
        },
        ...mapMutations([
            "setSearchOptions",
            "setRefreshSearchPage",
        ]),
        handleCancel() {
            this.searchText = "";
            this.$router.push({name: 'home'});
        },
        async handleSubmit()  {
            this.setRefreshSearchPage(true);
            this.$router.push({name: 'search', params: {text: this.options.searchText}});
        },
        changeSearchOptions() {
            this.setSearchOptions(this.options);
        }
    },
    computed: {
        ...mapGetters([
            "getSearchOptions",
        ])
    },
    watch: {

    }
}
</script>
<style lang="scss">
    .search-bar {
        label {
            span {
                padding-left: 5px;
            }
        }
    }
</style>
