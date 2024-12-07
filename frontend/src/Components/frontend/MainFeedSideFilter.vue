<template>
    <div class="mb-5 md:w-72 h-screen md:sticky top-0 bg-background-secondary rounded-md overflow-y-scroll" v-show="open">
        <header class="p-4">
            <font-awesome-icon :icon="['fas', 'times']" class="block ml-auto text-white text-3xl cursor-pointer" @click="$emit('closeFilter')" />
        </header>
        <ul class="pb-10">
            <BaseDisclosure sectionName="Thumbnail label on">
                <BaseCheckbox
                    id="thumbnail"
                    label="Thumbnail on"
                    @onChange="changeBooleanStatus('thumbnail')"
                    :checked="activeFilter.thumbnail"
                />
            </BaseDisclosure>

            <BaseDisclosure sectionName="Video quality">
                <BaseCheckbox
                    id="videoQuality"
                    label="Show just HD rooms"
                    @onChange="changeBooleanStatus('showJustHDRooms')"
                    :checked="activeFilter.showJustHDRooms"
                />
            </BaseDisclosure>

            <BaseDisclosure sectionName="New models">
                <BaseCheckbox
                    id="newModels"
                    label="Show just new models"
                    @change="changeBooleanStatus('showJustNewModels')"
                    :checked="activeFilter.showJustNewModels"
                />
            </BaseDisclosure>

            <BaseDisclosure sectionName="Genders">
                <BaseCheckbox
                    v-for="(gender, idx) in filter.genders"
                    :key="idx"
                    :id="gender"
                    :label="gender"
                    :checked="activeFilter?.genders.includes(gender)"
                    @onChange="removeOrInsert('genders', gender)"
                />
            </BaseDisclosure>

            <BaseDisclosure sectionName="Age">
                <BaseCheckbox
                    v-for="(age, idx) in filter.ages"
                    :key="idx"
                    :id="age"
                    :label="age"
                    @onChange="removeOrInsert('ages', age)"
                    :checked="activeFilter?.ages?.includes(age)"
                />
            </BaseDisclosure>

            <BaseDisclosure sectionName="Location">
                <Multiselect
                    :options="filter.locations"
                    v-model="locations"
                    :mode="'multiple'"
                />
            </BaseDisclosure>

            <BaseDisclosure sectionName="Chats">
                <BaseCheckbox
                    v-for="(chat, idx) in filter.chats"
                    :key="idx"
                    :id="chat"
                    :label="chat"
                    @onChange="removeOrInsert('chats', chat)"
                    :checked="activeFilter?.chats?.includes(chat)"
                />
            </BaseDisclosure>

            <BaseDisclosure sectionName="Status">
                <BaseCheckbox
                    v-for="(status, idx) in filter.statuses"
                    :key="idx"
                    :id="status"
                    :label="status"
                    @onChange="removeOrInsert('statuses', status)"
                    :checked="activeFilter?.statuses?.includes(status)"
                />
            </BaseDisclosure>

            <BaseDisclosure sectionName="Ethnicity">
                <BaseCheckbox
                    v-for="(ethnicity,idx) in filter.ethnicity"
                    :key="idx"
                    :id="ethnicity"
                    :label="ethnicity"
                    @onChange="removeOrInsert('ethnicity', ethnicity)"
                    :checked="activeFilter?.ethnicity?.includes(ethnicity)"
                />
            </BaseDisclosure>

            <BaseDisclosure sectionName="Body type">
                <BaseCheckbox
                    v-for="(btype,idx) in filter.body_types"
                    :key="idx"
                    :id="btype"
                    :label="btype"
                    @onChange="removeOrInsert('body_types', btype)"
                    :checked="activeFilter?.bodyTypes?.includes(btype)"
                />
            </BaseDisclosure>

            <BaseDisclosure sectionName="Height">
                <BaseCheckbox
                    v-for="(height, idx) in filter.height"
                    :key="idx"
                    :id="height"
                    :label="height"
                    @onChange="removeOrInsert('height', height)"
                    :checked="activeFilter?.heights?.includes(height)"
                />
            </BaseDisclosure>

            <BaseDisclosure sectionName="Weight">
                <BaseCheckbox
                    v-for="(weight,idx) in filter.weight"
                    :key="idx"
                    :id="weight"
                    :label="weight"
                    @onChange="removeOrInsert('weight', weight)"
                    :checked="activeFilter?.weights?.includes(weight)"
                />
            </BaseDisclosure>

            <BaseDisclosure sectionName="Hair color">
                <BaseCheckbox
                    v-for="(hairColor, idx) in filter.hair_color"
                    :key="idx"
                    :id="hairColor"
                    :label="hairColor"
                    @onChange="removeOrInsert('hair_color', hairColor)"
                    :checked="activeFilter?.hairColors?.includes(hairColor)"
                />
            </BaseDisclosure>

            <BaseDisclosure sectionName="Hair length">
                <BaseCheckbox
                    v-for="(hairLength, idx) in filter.hair_length"
                    :key="idx"
                    :id="hairLength"
                    :label="hairLength"
                    @onChange="removeOrInsert('hair_length', hairLength)"
                    :checked="activeFilter?.hairLengths?.includes(hairLength)"
                />
            </BaseDisclosure>

            <BaseDisclosure sectionName="Eye colors">
                <BaseCheckbox
                    v-for="(eyeColor, idx) in filter.eye_colors"
                    :key="idx"
                    :id="eyeColor"
                    :label="eyeColor"
                    @onChange="removeOrInsert('eye_colors', eyeColor)"
                    :checked="activeFilter?.eyeColors?.includes(eyeColor)"
                />
            </BaseDisclosure>

            <BaseDisclosure sectionName="Sex orientation">
                <BaseCheckbox
                    v-for="(sexOrientation, idx) in filter.sex_orientation"
                    :key="idx"
                    :id="sexOrientation"
                    :label="sexOrientation"
                    @onChange="removeOrInsert('sex_orientation', sexOrientation)"
                    :checked="activeFilter?.sexOrientations?.includes(sexOrientation)"
                />
            </BaseDisclosure>

            <BaseDisclosure sectionName="Pubic hair">
                <BaseCheckbox
                    v-for="(pubicHair, idx) in filter.pubic_hair"
                    :key="idx"
                    :id="pubicHair"
                    :label="pubicHair"
                    @onChange="removeOrInsert('pubic_hair', pubicHair)"
                    :checked="activeFilter?.pubicHairs?.includes(pubicHair)"
                />

            </BaseDisclosure>

            <BaseDisclosure sectionName="Bust/Penis size">
                <BaseCheckbox
                    v-for="(pbSize, idx) in filter.pb_size"
                    :key="idx"
                    :id="pbSize"
                    :label="pbSize"
                    @onChange="removeOrInsert('pb_size', pbSize)"
                    :checked="activeFilter?.bustPenisSizes?.includes(pbSize)"
                />
            </BaseDisclosure>

            <BaseDisclosure sectionName="Language">
                <BaseCheckbox
                    v-for="(language, idx) in filter.language"
                    :key="idx"
                    :id="language"
                    :label="language"
                    @onChange="removeOrInsert('language', language)"
                    :checked="activeFilter?.languages?.includes(language)"
                />
            </BaseDisclosure>
        </ul>
    </div>
</template>
<script>

import BaseDisclosure from "@/components/partials/BaseDisclosure.vue";
import BaseCheckbox from "@/components/partials/BaseCheckbox.vue";
import _ from "lodash";
import Multiselect from '@vueform/multiselect'
import {mapGetters, mapMutations, mapActions} from "vuex";

export default {
    name: "MainFeedSideFilter",
    components: {
        BaseCheckbox, BaseDisclosure, Multiselect
    },
    props: {
        open: Boolean,
    },
    data() {
        return {
            filter: [],
            activeFilter: [],
            locations: [],
        }
    },
    created() {
        this.filter = this.getFilter;
        this.activeFilter = this.getActiveFilter;
    },
    methods: {
        ...mapActions([
            "fetchRooms",
        ]),
        ...mapMutations([
            'setActiveFilter'
        ]),
        removeOrInsert(name, val) {
            if (_.includes(this.activeFilter[name], val)) {
                this.activeFilter[name] = this.activeFilter[name].filter((el) => el !== val);
            } else {
                this.activeFilter[name].push(val);
            }

            this.getFilteredData();
        },
        changeBooleanStatus(name) {
            this.activeFilter[name] = !this.activeFilter[name];
            this.getFilteredData();
        },
        getFilteredData() {
            this.fetchRooms({page: this.$route.params.query?.page ? this.$route.params.query?.page : 1, filter: this.getActiveFilter});
            this.setActiveFilter(this.activeFilter);
        }
    },
    computed: {
        ...mapGetters([
            'getFilter',
            "getSidebarFilter",
            "getActiveFilter",
        ])
    },
    watch: {
        'locations': function (newVal, oldVal) {
            this.getFilteredData();
            this.activeFilter.locations = newVal;
        }
    }
}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
