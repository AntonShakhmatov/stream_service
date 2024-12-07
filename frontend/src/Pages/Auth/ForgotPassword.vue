<template>
  <div>
    <!-- <Head :title="$t('mycustomadmin', 'Reset password')" /> -->
    <Head :title="$t('Reset password')" />

    <div
      class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10"
      v-auto-animate
    >
      <Alert v-if="status" type="info" class="mb-6">
        {{ status }}
      </Alert>

      <!-- :label="$t('mycustomadmin', 'E-mail address')" -->

      <form class="space-y-6" @submit.prevent="submit">
        <TextInput
          v-model="form.email"
          :label="$t('E-mail address')"
          name="email"
        />

        <Button class="w-full" type="submit" :disabled="form.processing">
          <!-- {{ $t("mycustomadmin", "Email Password Reset Link") }} -->
          {{ $t("Email Password Reset Link") }}
        </Button>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useForm, Head } from "@inertiajs/vue3";
import { Button, TextInput, Alert } from "@/components";

interface Props {
  status: string;
}

defineProps<Props>();

const form = useForm({
  email: "",
});

const submit = () => {
  form.post(route("password.email"));
};
</script>
