<template>
  <div>
    <nav class="mt-5 space-y-1">
      <!--      <SidebarGroup :title="$t('mycustomadmin', '')">-->
      <SidebarItem icon="xx" :href="route('dashboard')">
        {{ $t('Dashboard') }}
      </SidebarItem>
      <SidebarItem :href="route('room.index')" icon="xx">
        {{ $t('Rooms') }}

      </SidebarItem>
      <SidebarItem :href="route('aff.index')" icon="xx">
        {{ $t('AffLinks') }}

      </SidebarItem>
      <SidebarItem :href="route('favorite.index')" icon="xx">
        {{ $t('Set top rated models') }}

      </SidebarItem>
      <SidebarItem icon="xx" :href="route('users.index')">

        {{ $t('Users') }}</SidebarItem>

    </nav>
    <p>Sidebar is working!</p>
  </div>
</template>

<script setup lang="ts">
import {
  KeyIcon,
  LanguageIcon,
  PhotoIcon,
  UsersIcon,
  Cog8ToothIcon,
  CubeTransparentIcon,
} from "@heroicons/vue/24/outline";
import { SidebarItem, SidebarGroup } from "@/components/Sidebar";
</script>
