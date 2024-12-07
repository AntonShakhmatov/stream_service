<template>
    <PageHeader :title="`Edit user ${user.name}`">
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
        <UserForm :form="form" :roles="roles" :submit="submit" :isEdit="true" />
    </PageContent>
</template>

<script setup lang="ts">
import {
    PageHeader,
    PageContent,
    Button,
} from "@/components"
import UserForm from "@/Pages/Users/Form.vue"
import {useForm} from "@/hooks/useForm";

interface Props {
    roles: Object,
    user: Object
}

const props = defineProps<Props>();

const {form, submit} = useForm({
    name: props.user?.name ?? "",
    email: props.user?.email ?? "",
    role: props.user?.roles[0]?.id ?? "",
    password: ""
}, route('users.update', props.user), 'put');


</script>
