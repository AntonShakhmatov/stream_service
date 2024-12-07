<template>
    <PageHeader title="Create user">
        <Button
            :leftIcon="ArrowDownTrayIcon"
            @click="submit"
            :loading="form.processing"
        >
            <!-- {{ $t("mycustomadmin", "Save") }} -->
            {{ $t("Save") }}
        </Button>
    </PageHeader>
    <PageContent>
        <UserForm :form="form" :submit="submit" :roles="roles" :is-edit="false" />
    </PageContent>
</template>

<script setup lang="ts">
import {
    PageHeader,
    PageContent,
    Button,
} from '@/components';
import {useForm} from "@/hooks/useForm";
import UserForm from '@/Pages/Users/Form.vue';
import { ArrowDownTrayIcon } from "@heroicons/vue/20/solid";

interface Props {
    roles: Object,
}

const props = defineProps<Props>();

const {form, submit} = useForm({
    name: "",
    email: "",
    password: "",
    role: "",
}, route('users.store'), 'post');

</script>


