<template>
    <LayoutAuthenticated>
        <SectionMain>
            <SectionTitleLineWithButton :title="`Edit user - ${user.name}`" :has-cog="false" />
            <CardBox is-form @submit="saveUser">
                <Form :form="form" method="put" :link="route('users.update', user)" :is-edit="true" />
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>

<script setup>
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import SectionMain from "@/Components/SectionMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import CardBox from "@/Components/CardBox.vue";
import Form from '@/Pages/Users/Form.vue';
import {useForm} from "@inertiajs/vue3";
// import {defineProps} from "vue";

const props = defineProps({
    user: Object,
});

const form = useForm({
    name: props.user?.name ?? "",
    email: props.user?.email ?? "",
    password: "",
    confirm_password: "",
});

</script>

<style scoped>

</style>
