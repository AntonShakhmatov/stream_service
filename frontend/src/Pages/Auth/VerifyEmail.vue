<template>
  <div>
    <!-- <Head :title="$t('mycustomadmin', 'Verify e-mail')" /> -->
    <Head :title="$t('Verify e-mail')" />

    <div
      class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10"
      v-auto-animate
    >
      <p class="mb-6 text-center text-sm text-gray-600">
        {{
          // $t(
          //   "mycustomadmin",
          //   "Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another."
          // )         
          $t(
            "Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another."
          )
        }}
      </p>

      <Alert v-if="verificationLinkSent" type="success" class="mb-6">
        {{
          // $t(
          //   "mycustomadmin",
          //   "A new verification link has been sent to the email address you provided during registration."
          // )
          $t(
            "A new verification link has been sent to the email address you provided during registration."
          )
        }}
      </Alert>

      <form class="space-y-6" @submit.prevent="submit">
        <Button class="w-full" type="submit" :disabled="form.processing">
          <!-- {{ $t("mycustomadmin", "Resend Verification Email") }} -->
          {{ $t("Resend Verification Email") }}
        </Button>

        <div class="flex justify-center">
          <Link
            href="/admin/logout"
            method="post"
            class="text-sm font-medium text-primary-600 hover:text-primary-500"
          >
            <!-- {{ $t("mycustomadmin", " Log Out") }} -->
            {{ $t("Log Out") }}
          </Link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from "vue";
import { useForm, Head } from "@inertiajs/vue3";
import { Button, Alert } from "@/components";

interface Props {
  status: string;
}

const props = defineProps<Props>();

const form = useForm({});

const submit = () => {
  form.post(route("verification.send"));
};

const verificationLinkSent = computed(
  () => props.status === "verification-link-sent"
);
</script>
