<template>
    <section class="flex gap-2 items-end flex-wrap my-6">
        <div class="flex items-center gap-4 px-2 py-1 text-sm border border-stroke text-white" v-if="filter?.tag?.length" v-for="(tag,idx) in filter?.tag" :key="idx">
            Tag: {{ tag }}
            <font-awesome-icon :icon="['fas', 'xmark']"  @click="resetMultipleFilter('tag',tag)" class="h-4 w-4 hover:cursor-pointer" />
        </div>

        <div class="flex items-center gap-4 px-2 py-1 text-sm border border-stroke text-white" v-show="filter?.showJustHDRooms === 'true'">
            Show just HD rooms
            <font-awesome-icon :icon="['fas', 'xmark']" @click="resetBooleanFilter('showJustHDRooms')" class="h-4 w-4 hover:cursor-pointer" />
        </div>

        <div class="flex items-center gap-4 px-2 py-1 text-sm border border-stroke text-white" v-show="filter?.showJustNewModels == true">
            Show just new rooms
            <font-awesome-icon :icon="['fas', 'xmark']" @click="resetBooleanFilter('showJustNewModels')" class="h-4 w-4 hover:cursor-pointer" />
        </div>

        <div class="flex items-center gap-4 px-2 py-1 text-sm border border-stroke text-white" v-if="filter?.genders?.length" v-for="(gender, idx) in filter?.genders" :key="idx">
            Gender: {{ gender }}
            <font-awesome-icon :icon="['fas', 'xmark']" @click="resetMultipleFilter('genders', gender)" class="h-4 w-4 hover:cursor-pointer" />
        </div>

        <div class="flex items-center gap-4 px-2 py-1 text-sm border border-stroke text-white" v-if="filter?.ages" v-for="(age, idx) in filter?.ages" :key="idx">
            Age: {{ age }}
            <font-awesome-icon :icon="['fas', 'xmark']" @click="resetMultipleFilter('ages', age)" class="h-4 w-4 hover:cursor-pointer" />
        </div>

        <div class="flex items-center gap-4 px-2 py-1 text-sm border border-stroke text-white" v-if="filter?.locations" v-for="(location, idx) in filter?.locations" :key="idx">
            Location: {{ location }}
            <font-awesome-icon :icon="['fas', 'xmark']" @click="resetMultipleFilter('locations', location)" class="h-4 w-4 hover:cursor-pointer" />
        </div>

        <div class="flex items-center gap-4 px-2 py-1 text-sm border border-stroke text-white" v-if="filter?.chats" v-for="chat in filter.chats" :key="chat">
            Chat: {{ chat }}
            <font-awesome-icon :icon="['fas', 'xmark']" @click="resetMultipleFilter('chats', chat)" class="h-4 w-4 hover:cursor-pointer" />
        </div>

        <div class="flex items-center gap-4 px-2 py-1 text-sm border border-stroke text-white" v-if="filter?.statuses" v-for="statuses in filter.statuses" :key="statuses">
            Status: {{ statuses }}
            <font-awesome-icon :icon="['fas', 'xmark']" @click="resetMultipleFilter('statuses', statuses)" class="h-4 w-4 hover:cursor-pointer" />
        </div>

        <div class="flex items-center gap-4 px-2 py-1 text-sm border border-stroke text-white" v-if="filter?.ethnicity" v-for="ethnicity in filter.ethnicity" :key="ethnicity">
            Ethnicity: {{ ethnicity }}
            <font-awesome-icon :icon="['fas', 'xmark']" @click="resetMultipleFilter('ethnicity', ethnicity)" class="h-4 w-4 hover:cursor-pointer" />
        </div>

        <div class="flex items-center gap-4 px-2 py-1 text-sm border border-stroke text-white" v-if="filter?.body_types" v-for="bodyType in filter.body_types" :key="bodyType">
            Body type: {{ bodyType }}
            <font-awesome-icon :icon="['fas', 'xmark']" @click="resetMultipleFilter('body_types', bodyType)" class="h-4 w-4 hover:cursor-pointer" />
        </div>

        <div class="flex items-center gap-4 px-2 py-1 text-sm border border-stroke text-white" v-if="filter?.height" v-for="height in filter.height" :key="height">
            Height: {{ height }}
            <font-awesome-icon :icon="['fas', 'xmark']" @click="resetMultipleFilter('height', height)" class="h-4 w-4 hover:cursor-pointer" />
        </div>

        <div class="flex items-center gap-4 px-2 py-1 text-sm border border-stroke text-white" v-if="filter?.weight" v-for="weight in filter.weight" :key="weight">
            Weight: {{ weight }}
            <font-awesome-icon :icon="['fas', 'xmark']" @click="resetMultipleFilter('weight', weight)" class="h-4 w-4 hover:cursor-pointer" />
        </div>

        <div class="flex items-center gap-4 px-2 py-1 text-sm border border-stroke text-white" v-if="filter?.hair_color" v-for="hairColor in filter.hair_color" :key="hairColor">
            Hair color: {{ hairColor }}
            <font-awesome-icon :icon="['fas', 'xmark']" @click="resetMultipleFilter('hair_color', hairColor)" class="h-4 w-4 hover:cursor-pointer" />
        </div>

        <div class="flex items-center gap-4 px-2 py-1 text-sm border border-stroke text-white" v-if="filter?.hair_length" v-for="hairLength in filter.hair_length" :key="hairLength">
            Hair length: {{ hairLength }}
            <font-awesome-icon :icon="['fas', 'xmark']" @click="resetMultipleFilter('hair_length', hairLength)" class="h-4 w-4 hover:cursor-pointer" />
        </div>

        <div class="flex items-center gap-4 px-2 py-1 text-sm border border-stroke text-white" v-if="filter?.eye_colors" v-for="eyeColor in filter.eye_colors" :key="eyeColor">
            Eye color: {{ eyeColor }}
            <font-awesome-icon :icon="['fas', 'xmark']" @click="resetMultipleFilter('eye_colors', eyeColor)" class="h-4 w-4 hover:cursor-pointer" />
        </div>

        <div class="flex items-center gap-4 px-2 py-1 text-sm border border-stroke text-white" v-if="filter?.sex_orientation" v-for="sexOrientation in filter.sex_orientation" :key="sexOrientation">
            Sex orientation: {{ sexOrientation }}
            <font-awesome-icon :icon="['fas', 'xmark']" @click="resetMultipleFilter('sex_orientation', sexOrientation)" class="h-4 w-4 hover:cursor-pointer" />
        </div>

        <div class="flex items-center gap-4 px-2 py-1 text-sm border border-stroke text-white" v-if="filter?.pubic_hair" v-for="pubicHair in filter.pubic_hair" :key="pubicHair">
            Pubic hair: {{ pubicHair }}
            <font-awesome-icon :icon="['fas', 'xmark']" @click="resetMultipleFilter('pubic_hair', pubicHair)" class="h-4 w-4 hover:cursor-pointer" />
        </div>

        <div class="flex items-center gap-4 px-2 py-1 text-sm border border-stroke text-white" v-if="filter?.pb_size" v-for="pbSize in filter.pb_size" :key="pbSize">
            Bust/Penis size: {{ pbSize }}
            <font-awesome-icon :icon="['fas', 'xmark']" @click="resetMultipleFilter('pb_size', pbSize)" class="h-4 w-4 hover:cursor-pointer" />
        </div>

        <div class="flex items-center gap-4 px-2 py-1 text-sm border border-stroke text-white" v-if="filter?.language" v-for="language in filter.language" :key="language">
            Language: {{ language }}
            <font-awesome-icon :icon="['fas', 'xmark']" @click="resetMultipleFilter('language', language)" class="h-4 w-4 hover:cursor-pointer" />
        </div>

    </section>
</template>

<script>
import {mapGetters, mapActions, mapMutations} from "vuex";

export default {
    name: "ActiveFilters",
    created() {
        this.filter = this.getActiveFilter;
    },
    data() {
        return {
            filter: [],
        }
    },
    methods: {
        resetBooleanFilter(val) {
            this.filter[val] = false;
            this.$emit('resetFilter', this.filter);
        },
        resetMultipleFilter(name, val) {
            this.filter[name] = this.filter[name].filter((el) => el !== val);
            this.$emit('resetFilter');
        }
    },
    computed: {
        ...mapGetters([
            'getActiveFilter',
        ]),
    },
    watch: {
        'getActiveFilter': function () {
            this.filter = this.getActiveFilter;
        }
    }
}
</script>

<style scoped>

</style>
