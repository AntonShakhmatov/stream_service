<template>
  <div>
    <!-- <Head :title="$t('mycustomadmin', 'Reset password')" /> -->
    <Head :title="$t('Reset password')" />

    <!-- :label="$t('mycustomadmin', 'E-mail address')" -->

    <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
      <form class="space-y-6" @submit.prevent="submit">
        <TextInput
          v-model="form.email"
          :label="$t('E-mail address')"
          name="email"
        />

        <!-- :label="$t('mycustomadmin', 'Password')" -->

        <TextInput
          v-model="form.password"
          :label="$t('Password')"
          name="password"
          type="password"
          autocomplete="new-password"
        />

        <!-- :label="$t('mycustomadmin', 'Confirm Password')" -->

        <TextInput
          v-model="form.password_confirmation"
          :label="$t('Confirm Password')"
          name="password_confirmation"
          type="password"
          autocomplete="new-password"
        />

        <Button class="w-full" type="submit" :disabled="form.processing">
          <!-- {{ $t("mycustomadmin", "Reset Password") }} -->
          {{ $t("Reset Password") }}
        </Button>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useForm, Head } from "@inertiajs/vue3";
import { Button, TextInput } from "@/components";

interface Props {
  email: string;
  token: string;
}

const props = defineProps<Props>();

const form = useForm({
  token: props.token,
  email: props.email,
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.post(route("password.update"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>
