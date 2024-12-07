<template>
  <div class="flex flex-wrap justify-evenly gap-2">
    <SecondaryButton
      v-for="gender in genders"
      :key="gender"
      :active="filter.genders.includes(gender)"
      @clicked="changeGenders(gender)"
      >{{ gender }}</SecondaryButton
    >
  </div>
</template>

<script>
import SecondaryButton from "@/components/partials/SecondaryButton.vue";
import _ from "lodash";
import {mapGetters, mapActions} from "vuex";

export default {
    components: {SecondaryButton},

    data() {
        return {
            filter: [],
            genders: [],
        }
    },
    created() {
        this.filter = this.getActiveFilter;
        this.genders = this.getFilter.genders;
    },
    methods: {
        changeGenders(val) {
            if (_.includes(this.filter?.genders, val)) {
                this.filter.genders = this.filter.genders.filter((el) => el !== val);
            } else {
                this.filter?.genders.push(val);
            }
            this.$emit('changeFilter')
        }
    },
    computed: {
        ...mapGetters([
            'getActiveFilter',
            "getFilter",
        ]),
    }

}
</script>

