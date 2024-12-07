<template>
  <form>
    <div class="my-4">
      <label class="mb-1 block text-sm font-medium text-gray-700" for="file">
        <template v-if="importedFile">
          {{ importedFile.name }}
        </template>
        <template v-else> {{ $t("mycustomadmin", "Choose file") }} </template>
      </label>
      <input
        id="file"
        ref="file"
        class="w-full"
        name="importFile"
        type="file"
        @input="handleImportFileUpload"
      />
    </div>
    <Multiselect
      v-model="importLanguage"
      :options="locales"
      :label="$t('mycustomadmin', 'Languages to import')"
      mode="single"
      name=""
    />
    <Checkbox
      v-model="onlyMissing"
      class="mt-2"
      :label="$t('mycustomadmin', 'Do not override existing translations')"
    />
  </form>
</template>

<script lang="ts" setup>
import { Multiselect } from "@/components";
import { ref, watchEffect } from "vue";
import Checkbox from "@/components/Checkbox.vue";

interface Props {
  locales: string[];
  processing: boolean;
}

const props = defineProps<Props>();

const emit = defineEmits(["uploadFile", "selectLanguage", "checkOnlyMissing"]);

const file = ref(null);
const importLanguage = ref(null);
const importedFile = ref(null);
const onlyMissing = ref<boolean>(false);

const handleImportFileUpload = (e: any) => {
  importedFile.value = e.target.files[0];
  emit("uploadFile", e.target.files[0], file?.value?.files[0]);
};

watchEffect(() => {
  emit("selectLanguage", importLanguage.value);
});

watchEffect(() => {
  emit("checkOnlyMissing", onlyMissing.value);
});
</script>
