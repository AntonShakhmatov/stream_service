<template>
  <Modal class="flex items-center justify-center">
    <template #trigger="{ setIsOpen }">
      <ToolbarButton @click="() => setIsOpen(true)" :icon="VideoCameraIcon" />
    </template>
    <!-- <template #title> {{ $t("mycustomadmin", "Add Youtube video") }} </template> -->
    <template #title> {{ $t("Add Youtube video") }} </template>
    <template #content>
      <!-- :label="$t('mycustomadmin', 'Youtube URL')" -->
      <TextInput
        name="youtube_url"
        :label="$t('Youtube URL')"
        v-model="form.url"
      />
    </template>
    <template #buttons="{ setIsOpen }">
      <Button
        @click="
          () => {
            setIsOpen(false);
            submit();
          }
        "
      >
        <!-- {{ $t("mycustomadmin", "Submit") }} -->
        {{ $t("Submit") }}
      </Button>
      <Button variant="outline" @click="() => setIsOpen(false)">
        <!-- {{ $t("mycustomadmin", "Cancel") }} -->
        {{ $t("Cancel") }}
      </Button>
    </template>
  </Modal>
</template>
<script setup lang="ts">
import ToolbarButton from "./ToolbarButton.vue";
import { Modal, Button, TextInput } from "@/components";
import { useForm } from "@inertiajs/vue3";
import { VideoCameraIcon } from "@heroicons/vue/24/solid";

const emit = defineEmits(["youtubeAdded"]);

interface Props {
  url?: string;
}

const props = defineProps<Props>();

const form = useForm({
  url: props.url || "",
});

const submit = () => {
  emit("youtubeAdded", form.url);
  form.url = "";
};
</script>
