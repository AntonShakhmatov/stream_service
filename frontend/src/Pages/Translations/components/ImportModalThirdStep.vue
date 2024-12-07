<template>
  <p class="text-sm font-medium text-gray-700">
    {{
      $t("mycustomadmin", ":count successfully imported", {
        count: numberOfSuccessfullyImportedTranslations.toString(),
      })
    }}
    {{
      $t("mycustomadmin", ":count successfully updated", {
        count: numberOfSuccessfullyUpdatedTranslations.toString(),
      })
    }}
  </p>
</template>

<script lang="ts" setup>
interface Props {
  numberOfSuccessfullyImportedTranslations: number;
  numberOfSuccessfullyUpdatedTranslations: number;
}

const props = defineProps<Props>();
</script>
