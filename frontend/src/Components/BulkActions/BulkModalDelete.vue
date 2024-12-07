<template>
    <Modal type="danger">
        <template #trigger="{ setIsOpen }">
            <Button
                @click="() => setIsOpen(true)"
                color="gray"
                variant="outline"
                size="sm"
                :leftIcon="TrashIcon"
            >
                <!-- {{ $t("mycustomadmin", "Delete") }} -->
                {{ $t("Delete") }}
            </Button>
        </template>

        <template #title>
            {{ deleteTitle }}
        </template>
        <template #content>
            <slot></slot>
        </template>

        <template #buttons="{ setIsOpen }">
            <Button
                @click.prevent="
                () => {
                  bulkAction('post', deleteUrl, {
                    onFinish: () => setIsOpen(false),
                  });
                }
              "
                color="danger"
            >
                <!-- {{ $t("mycustomadmin", "Delete") }} -->
                {{ $t("Delete") }}
            </Button>
            <Button
                @click.prevent="() => setIsOpen()"
                color="gray"
                variant="outline"
            >
                <!-- {{ $t("mycustomadmin", "Cancel") }} -->
                {{ $t("Cancel") }}
            </Button>
        </template>
    </Modal>
</template>

<script setup lang="ts">
import {Modal, Button} from "@/components";

interface Props {
    deleteTitle: string;
    deleteUrl: string;
    bulkAction: any;
}

defineProps<Props>()
</script>

