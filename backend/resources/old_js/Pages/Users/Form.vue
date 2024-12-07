<template>
    <div>
        <div class="grid grid-cols-1 gap-6">
            <CardBox is-form @submit.prevent="submitForm">
                <FormField label="Name" help="Required. Your name">
                    <FormControl
                        v-model="form.name"
                        :icon="mdiAccount"
                        name="username"
                        required
                        autocomplete="username"
                    />
                </FormField>
                <FormField label="E-mail" help="Required. Your e-mail">
                    <FormControl
                        v-model="form.email"
                        :icon="mdiMail"
                        type="email"
                        name="email"
                        required
                        autocomplete="email"
                    />
                </FormField>

                <FormField label="New password" help="Required. New password">
                    <FormControl
                        v-model="form.password"
                        :icon="mdiFormTextboxPassword"
                        name="password"
                        type="password"
                        :required="!isEdit"
                        autocomplete="new-password"
                        @change="checkPasswords"
                    />
                </FormField>

                <FormField label="Confirm password" help="Required. New password one more time">
                    <FormControl
                        v-model="form.confirm_password"
                        :icon="mdiFormTextboxPassword"
                        name="password_confirmation"
                        type="password"
                        :required="!isEdit"
                        autocomplete="new-password"
                        @change="checkPasswords"
                    />
                </FormField>

                <template #footer>
                    <BaseButtons>
                        <BaseButton type="submit" color="info" label="Submit" :disabled="!submitBtn" />
                    </BaseButtons>
                </template>
            </CardBox>
        </div>
    </div>
</template>

<script setup>
import {computed, ref} from "vue";
import CardBox from "@/Components/CardBox.vue";
import FormField from "@/Components/FormField.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import BaseButton from "@/Components/BaseButton.vue";
import FormControl from "@/Components/FormControl.vue";
import {mdiFormTextboxPassword, mdiAccount, mdiMail} from '@mdi/js';
import {router} from "@inertiajs/vue3";

const submitBtn = ref(false);

const props = defineProps({
    form: Object,
    link: String,
    method: String,
    isEdit: {
        type: Boolean,
        default: false,
    }
});

const submitForm = () => {
    router.visit(props.link, {
        method: props.method,
        data: props.form
    });
};

const checkPasswords = computed(() => {
    if (!props.isEdit) {
        submitBtn.value = props.form.password === props.form.confirm_password;
    } else {
        submitBtn.value = true;
    }
});

</script>

<style scoped>

</style>
