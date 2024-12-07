<template>
  <PageHeader :title="$t('mycustomadmin', 'Translations')">
    <div class="flex">
      <ExportModal
        @toggle-open="exportModalOpened = !exportModalOpened"
        :open="exportModalOpened"
        :locales="locales"
        v-can="'translation.export'"
      />
      <ImportModal
        @toggle-open="importModalOpened = !importModalOpened"
        :open="importModalOpened"
        :locales="locales"
        v-can="'translation.import'"
      />
      <ButtonGroup>
        <Button
          @click="
            () => {
              action(
                'post',
                `/admin/translations/publish`,
                {},
                {
                  onSuccess: () => {
                    reload();
                  },
                }
              );
            }
          "
          v-can="'translation.publish'"
        >
          {{ $t("mycustomadmin", "Publish translations") }}
        </Button>
        <Dropdown
          noContentPadding
          v-can:any="[
            'translation.export',
            'translation.import',
            'translation.rescan',
          ]"
        >
          <template #button>
            <IconButton :icon="ChevronDownIcon" class="rounded-l-none" />
          </template>

          <template #content>
            <div class="py-1">
              <DropdownItem
                @click="
                  () => {
                    action('post', `/admin/translations/rescan`);
                    toast.warning(
                      $t('mycustomadmin', 'Scanning translations...')
                    );
                  }
                "
                v-can="'translation.rescan'"
              >
                {{ $t("mycustomadmin", "Re-scan translations") }}
              </DropdownItem>
              <DropdownItem
                @click="exportModalOpened = true"
                v-can="'translation.export'"
              >
                {{ $t("mycustomadmin", "Export") }}
              </DropdownItem>
              <DropdownItem
                @click="importModalOpened = true"
                v-can="'translation.import'"
              >
                {{ $t("mycustomadmin", "Import") }}
              </DropdownItem>
            </div>
          </template>
        </Dropdown>
      </ButtonGroup>
    </div>
  </PageHeader>

  <PageContent>
    <Listing
      :data="data"
      :baseUrl="route('translations.index')"
      :withBulkSelect="false"
    >
      <template #actions>
        <FiltersDropdown
          :activeFiltersCount="activeFiltersCount"
          :resetFilters="resetFilters"
        >
          <Multiselect
            v-model="filtersForm.group"
            :options="groups"
            :label="$t('mycustomadmin', 'Groups')"
            mode="tags"
            name="groups"
          />
        </FiltersDropdown>
      </template>
      <template #tableHead>
        <ListingHeaderCell sortBy="group">
          {{ $t("mycustomadmin", "Group") }}
        </ListingHeaderCell>

        <ListingHeaderCell sortBy="key">
          {{ $t("mycustomadmin", "Default") }}
        </ListingHeaderCell>

        <ListingHeaderCell>
          {{ ($page.props as PageProps).auth.user.locale }}
        </ListingHeaderCell>

        <ListingHeaderCell>
          {{ $t("mycustomadmin", "Last update") }}
        </ListingHeaderCell>

        <ListingHeaderCell></ListingHeaderCell>
      </template>
      <template #tableRow="{ item, action }">
        <ListingDataCell>
          {{ item.group }}
        </ListingDataCell>

        <ListingDataCell>
          <div class="max-w-sm overflow-hidden text-ellipsis">
            {{ item.key }}
          </div>
        </ListingDataCell>

        <ListingDataCell>
          <div class="max-w-sm overflow-hidden text-ellipsis">
            {{ item.text[($page.props as PageProps).auth.user.locale] }}
          </div>
        </ListingDataCell>

        <ListingDataCell>
          {{ dayjs(item.updated_at).format("DD.MM.YYYY HH:mm") }}
        </ListingDataCell>

        <ListingDataCell>
          <div class="flex items-center justify-end gap-3">
            <EditTranslationModal
              :language-line="item"
              :locales="locales"
              v-can="'translation.edit'"
            ></EditTranslationModal>
          </div>
        </ListingDataCell>
      </template>
    </Listing>
  </PageContent>
</template>

<script lang="ts" setup>
import { EllipsisVerticalIcon } from "@heroicons/vue/24/solid";
import {
  Button,
  Listing,
  ListingDataCell,
  ListingHeaderCell,
  Multiselect,
  PageHeader,
  PageContent,
  IconButton,
  Dropdown,
  FiltersDropdown,
  DropdownItem,
  ButtonGroup,
} from "@/components";
import { PaginatedCollection } from "@/types/pagination";
import type { LanguageLine } from "@/types/models";
import type { PageProps } from "@/types/page";
import { useAction } from "@/hooks/useAction";
import EditTranslationModal from "@/Pages/Translations/components/EditTranslationModal.vue";
import ExportModal from "@/Pages/Translations/components/ExportModal.vue";
import ImportModal from "@/Pages/Translations/components/ImportModal.vue";
import { useToast } from "vue-toastification";
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useListingFilters } from "@/hooks/useListingFilters";
import dayjs from "dayjs";
import { ChevronDownIcon } from "@heroicons/vue/24/outline";

interface Props {
  data: PaginatedCollection<LanguageLine>;
  groups: string[];
  locales: string[];
}

const toast = useToast();
const { action } = useAction();
const exportModalOpened = ref<boolean>(false);
const importModalOpened = ref<boolean>(false);

defineProps<Props>();

const { filtersForm, resetFilters, activeFiltersCount } = useListingFilters(
  route("translations.index"),
  {
    group: (usePage().props as PageProps)?.filter?.group ?? null,
  }
);

const reload = () => {
  window.location.reload();
};
</script>
