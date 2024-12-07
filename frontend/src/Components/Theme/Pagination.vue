<template>
    <div class="p-3 lg:px-6 border-t border-gray-100 dark:border-slate-800 relative" :class="{'flex justify-center': centered}">
        <BaseLevel>
            <Multiselect
                mode="single"
                :options="[10,25,50,100]"
                style="width: 100px;color: black;"
                v-model="data.per_page"
                @select="updatePerPage"
                class="!absolute left-5"
                :can-deselect="false"
                :can-clear="false"
            />
            <BaseButtons>
                <BaseButton
                    v-for="page in data.links"
                    :key="page"
                    :active="page.active"
                    :html-label="page.label"
                    :color="page.active ? 'lightDark bg-black' : 'whiteDark'"
                    small
                    :href="page.url"
                />
            </BaseButtons>
            <small class="absolute right-5">Page {{ data.current_page }} of {{ data.last_page }}</small>
        </BaseLevel>
    </div>
</template>

<script setup>
// import {defineProps, ref} from "vue";
import BaseLevel from "@/components/BaseLevel.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import BaseButton from "@/components/BaseButton.vue";
import Multiselect from '@vueform/multiselect';
import {router} from '@inertiajs/vue3';

const props = defineProps({
    data: Object,
    centered: Boolean,
});

const updatePerPage = () => {
    router.get(props.data.path+"?perPage="+props.data.per_page)
}


</script>
<style src="@vueform/multiselect/themes/default.css"></style>
