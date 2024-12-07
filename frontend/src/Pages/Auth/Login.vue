<template>
    <GuestLayout>

        <!-- <Head :title="$t('mycustomadmin', 'Login')" /> -->
        <Head :title="$t('Login')" />
        <SectionFullScreen v-slot="{ cardClass }" bg="purplePink">
            <CardBox class="w-1/3">
                <div class="flex w-full justify-center">
                    <!-- <img src="/images/logo.png" alt="Logo mycamstars" /> -->
                </div>
                <Alert v-if="status" type="info" class="mb-6">
                    {{ status }}
                </Alert>

                <form class="space-y-6" :action="route('login')" method="POST">
                    <input type="hidden" name="_token" :value="csrfToken">
                    <!-- <TextInput v-model="form.email" :label="$t('mycustomadmin', 'Login')" name="email" -->
                    <TextInput v-model="form.email" :label="$t('Login')" name="email"
                        label-class="text-white" />

                    <!-- <TextInput v-model="form.password" :label="$t('mycustomadmin', 'Password')" name="password" -->
                    <TextInput v-model="form.password" :label="$t('Password')" name="password"
                        label-class="text-white" type="password" />

                    <div class="flex items-center justify-between">
                        <!-- <Checkbox v-model="form.remember" :label="$t('mycustomadmin', 'Remember me')" name="remember-me" -->
                        <Checkbox v-model="form.remember" :label="$t('Remember me')" name="remember-me"
                            label-class="text-white" />
                    </div>

                    <Button class="w-full bg-gradient-to-r from-cyan-500 to-blue-500" type="submit"
                        :disabled="form.processing">
                        <!-- {{ $t("mycustomadmin", "Login") }} -->
                        {{ $t("Login") }}
                    </Button>
                </form>
            </CardBox>
        </SectionFullScreen>
    </GuestLayout>
</template>

<script setup lang="ts">
import { useForm, Head, usePage } from "@inertiajs/vue3";
import { Button, TextInput, Checkbox, Alert } from "@/components";
import { computed } from "vue";
import { Page } from "@inertiajs/core";
import { GuestLayout } from "@/Layouts";
import CardBox from "@/components/Theme/CardBox.vue";
import SectionFullScreen from '@/components/Theme/SectionFullScreen.vue'
import FormCheckRadio from "@/components/Theme/FormCheckRadio.vue";

interface Props {
    status: string | null;
}

defineProps<Props>();

const form = useForm({
    email: "",
    password: "",
    remember: false,
});
const csrfToken = computed(() => (usePage() as Page).props.csrf_token);

</script>
