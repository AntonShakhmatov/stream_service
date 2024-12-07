<template>
    <div class="w-full flex justify-center min-h-screen ">
        <div class="w-1/2 ">
            <TextInput
                name="name"
                v-model="form.name"
                label="Meno"
                class="mb-3"
            />
            <TextInput
                name="email"
                v-model="form.email"
                label="Email"
                type="email"
                class="mb-3"
            />
            <TextInput
                name="password"
                v-model="form.password"
                type="password"
                label="Heslo"
                class="mb-3"
            />
            <!-- :options="['admin', 'user']" -->
            <p v-if="isEdit">Ponechajte prázdne heslo sa nezmení</p>
            <Multiselect
                name="role"
                :options="roles"
                label="Rola"
                mode="single"
                v-model="form.role"
            />
        </div>
    </div>
</template>

<script setup lang="ts">
import {
    TextInput,
    Multiselect,
} from "@/components/";

import {ref, computed} from "vue";


interface Props {
    form: Object,
    roles: Object,
    isEdit: boolean,
}

defineProps<Props>()

const roles = computed(() => [
    'admin', 'user'
]);
</script>

<style scoped>

</style>
