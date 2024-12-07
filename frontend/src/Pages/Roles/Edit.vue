<template>
    <!-- :title="`${$t('mycustomadmin', 'Edit permissions for role')} ${role.name}`" -->
  <PageHeader
    sticky
    :title="`${$t('Edit permissions for role')} ${role.name}`"
  >
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
    <Form :form="form" :role="role" :submit="submit" />
  </PageContent>
</template>

<script setup lang="ts">
import { ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import { PageHeader, PageContent, Button } from "@/components";
import { useForm } from "@/hooks/useForm";
import Form from "./Form.vue";
import type { Role } from "@/types/models";

interface Props {
  role: Role;
  permissionsTree: any;
}

const props = defineProps<Props>();

const { form, submit } = useForm<any>(
  {
    permissionsTree: props.permissionsTree,
  },
  route("roles.update", [props.role.id])
);
</script>
