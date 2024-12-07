<template>
    <LayoutAuthenticated>
        <SectionMain>
            <SectionTitleLineWithButton title="Create user" :has-cog="false" />
            <CardBox is-form @submit="saveUser">
                <Form :form="form" method="post" :link="route('users.store')" />
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

const form = useForm({
    name: "",
    email: "",
    password: "",
    confirm_password: "",
});


</script>

<style scoped>

</style>
