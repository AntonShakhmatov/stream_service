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
                {{ assignTopButton }}
            </Button>
        </template>

        <template #title>
            {{ assignTitle }}
        </template>
        <template #content>
            <slot></slot>
        </template>

        <template #buttons="{ setIsOpen }">
            <Button
                @click.prevent="
                () => {
                  bulkAction('post', assignUrl, {
                    onFinish: () => setIsOpen(false),
                  });
                }
              "
                color="info"
            >
                <!-- {{ $t("mycustomadmin", "Assign") }} -->
                {{ $t("Assign") }}
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
    assignUrl: string;
    assignTitle: string;
    assignTopButton: string;
}

defineProps<Props>()
</script>

<style scoped>

</style>
