<template>
  <div class="flex flex-1 flex-col border-r border-gray-200 dark bg-slate-800">
    <div class="h-0 flex-1 overflow-y-auto pb-4 pt-5 xl:pl-2">
      <div class="flex flex-shrink-0 items-center px-4">
        <div class="h-10" />
        <img src="@/assets/images/logo.png" alt="Logo mycamstars" />
      </div>
      <SidebarContent class="px-4" />
    </div>
    <div class="flex flex-shrink-0 border-t border-gray-200 bg-gray-100 p-4">
      <div class="flex w-full items-center">
        <Avatar :src="user?.avatar_url" :name="user?.name" />
        <div class="ml-3">
          <p class="text-sm font-medium text-gray-700">
            {{ user?.name }}
          </p>
        </div>
        <UserDropdown class="ml-auto" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { UserDropdown, Avatar } from "@/components";
import { useUser } from "@/hooks/useUser";
import { SidebarContent } from "@/components";

const { user } = useUser();
</script>
