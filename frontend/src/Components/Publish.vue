<template>
  <div class="flex gap-1">
    <div v-if="!isPublished">
      <Modal type="info">
        <template #trigger="{ setIsOpen }">
          <Button
            @click="() => setIsOpen(true)"
            color="gray"
            variant="outline"
            :leftIcon="CheckCircleIcon"
            :size="size"
          >
            <!-- {{ $t("mycustomadmin", "Publish") }} -->
            {{ $t("Publish") }}
          </Button>
        </template>

        <template #title>
          <!-- {{ $t("mycustomadmin", "Publish") }} -->
          {{ $t("Publish") }}
        </template>

        <!-- :label="$t('mycustomadmin', 'Set publish date and time')" -->

        <template #content>
          <DatePicker
            name="published_at"
            v-model="publishLaterForm.published_at"
            :mode="mode"
            :label="$t('Set publish date and time')"
          />
        </template>

        <template #buttons="{ setIsOpen }">
          <Button
            @click.prevent="
              () => {
                action(
                  'patch',
                  updateUrl,
                  {
                    [columnName]: publishLaterForm.published_at,
                  },
                  {
                    onFinish: () => {
                      setIsOpen(false);
                    },
                  }
                );
              }
            "
            color="primary"
          >
            {{
              isScheduledPublish
                // ? $t("mycustomadmin", "Schedule publishing")
                ? $t("Schedule publishing")
                // : $t("mycustomadmin", "Publish")
                : $t("Publish")
            }}
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
    </div>

    <template v-if="isPublished">
      <ButtonGroup>
        <Modal type="warning">
          <template #trigger="{ setIsOpen }">
            <Tooltip :position="tooltipPosition">
              <template #button>
                <Button
                  @click="() => setIsOpen(true)"
                  color="gray"
                  variant="outline"
                  :size="size"
                  class="rounded-r-none"
                >
                  <component
                    :is="isScheduledPublish ? ClockIcon : CheckCircleIconSolid"
                    class="-ml-1 mr-2 h-4 w-4 flex-shrink-0 stroke-2"
                    :class="isScheduledPublish ? '' : 'text-green-500'"
                    aria-hidden="true"
                  />

                  {{
                    mode === "dateTime"
                      ? dayjs(publishedAt).format("DD.MM.YYYY HH:mm")
                      : dayjs(publishedAt).format("DD.MM.YYYY")
                  }}
                </Button>
              </template>
              <template #content>
                {{
                  isScheduledPublish
                    // ? $t("mycustomadmin", "Reschedule")
                    ? $t("Reschedule")
                    // : $t("mycustomadmin", "Change published at")
                    : $t("Change published at")
                }}
              </template>
            </Tooltip>
          </template>

          <template #title>
            <!-- {{ $t("mycustomadmin", "Edit publish date") }} -->
            {{ $t("Edit publish date") }}
          </template>

          <!-- :label="$t('mycustomadmin', 'Set publish date and time')" -->

          <template #content>
            <DatePicker
              name="published_at"
              v-model="publishLaterForm.published_at"
              :mode="mode"
              :label="$t('Set publish date and time')"
            />
          </template>

          <template #buttons="{ setIsOpen }">
            <Button
              @click.prevent="
                () => {
                  action(
                    'patch',
                    updateUrl,
                    {
                      [columnName]: publishLaterForm.published_at,
                    },
                    {
                      onFinish: () => {
                        setIsOpen(false);
                      },
                    }
                  );
                }
              "
              color="primary"
            >
              {{
                isScheduledPublish
                  // ? $t("mycustomadmin", "Schedule publishing")
                  ? $t("Schedule publishing")
                  // : $t("mycustomadmin", "Publish")
                  : $t("Publish")
              }}
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

        <Modal type="danger">
          <template #trigger="{ setIsOpen }">
            <Tooltip :position="tooltipPosition">
              <template #button>
                <IconButton
                  @click="() => setIsOpen(true)"
                  :icon="XMarkIcon"
                  color="gray"
                  variant="outline"
                  class="!bg-gray-50 hover:!bg-gray-100 -ml-px rounded-l-none stroke-2"
                  :size="size"
                />
              </template>
              <template #content>
                {{
                  isScheduledPublish
                    // ? $t("mycustomadmin", "Cancel schedulement")
                    ? $t("Cancel schedulement")
                    // : $t("mycustomadmin", "Unpublish")
                    : $t("Unpublish")
                }}
              </template>
            </Tooltip>
          </template>

          <template #title>
            <!-- {{ $t("mycustomadmin", "Unpublish") }} -->
            {{ $t("Unpublish") }}
          </template>

          <template #content>
            <!-- {{ $t("mycustomadmin", "Are you sure you want to unpublish?") }} -->
            {{ $t( "Are you sure you want to unpublish?") }}
          </template>

          <template #buttons="{ setIsOpen }">
            <Button
              @click.prevent="
                () => {
                  action(
                    'patch',
                    updateUrl,
                    {
                      [columnName]: null,
                    },
                    {
                      onFinish: () => {
                        setIsOpen(false);
                      },
                    }
                  );
                }
              "
              color="danger"
            >
              <!-- {{ $t("mycustomadmin", "Unpublish") }} -->
              {{ $t("Unpublish") }}
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
      </ButtonGroup>
    </template>
  </div>
</template>

<script setup lang="ts">
import {
  Button,
  Modal,
  DatePicker,
  IconButton,
  ButtonGroup,
  Tooltip,
} from "@/components";
import {
  CheckCircleIcon,
  ClockIcon,
  XMarkIcon,
} from "@heroicons/vue/24/outline";
import { CheckCircleIcon as CheckCircleIconSolid } from "@heroicons/vue/24/solid";
import { useAction } from "@/hooks/useAction";
import { computed, watch } from "vue";
import dayjs from "dayjs";
import { useForm } from "@inertiajs/vue3";
import type { DatePickerMode, SizesType } from "@/types";

const { action } = useAction();

interface Props {
  publishedAt: string | null;
  updateUrl: string;
  columnName: string;
  mode?: DatePickerMode;
  size?: SizesType;
  tooltipPosition?: "top" | "bottom";
}

const props = withDefaults(defineProps<Props>(), {
  mode: "dateTime",
  size: "sm",
  tooltipPosition: "top",
});

const isPublished = computed(() => {
  return props.publishedAt;
});

const isScheduledPublish = computed(() => {
  if (publishLaterForm.published_at) {
    return dayjs(publishLaterForm.published_at).isAfter(dayjs());
  }

  return false;
});

const publishLaterForm = useForm({
  published_at: props.publishedAt ?? dayjs().format("YYYY-MM-DD HH:mm"),
});
</script>
