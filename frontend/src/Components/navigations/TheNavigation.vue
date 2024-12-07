<template>
  <nav
    :class="[
      !expanded && 'w-0 opacity-0 hidden',
      'h-screen w-64  fixed left-0 top-0 transform transition-all opacity-100 bg-secondary-color z-50',
    ]"
  >
    <ul class="mt-24 text-white">
      <li class="text-white hover:bg-primary-color hover:bg-opacity-75 p-2 hover:cursor-pointer">
        <router-link class="" :to="{name: 'home'}">
            <font-awesome-icon :icon="['fass', 'house']" />
          Home
        </router-link>
      </li>
      <li class="text-white hover:bg-primary-color hover:bg-opacity-75 p-2 hover:cursor-pointer">
        <a class="link" to="#">
          <font-awesome-icon :icon="['fass', 'comment-dots']" />
          Chat rooms
        </a>
      </li>
      <li class="text-white hover:bg-primary-color hover:bg-opacity-75 p-2 hover:cursor-pointer">
        <a class="link" to="#">
            <font-awesome-icon :icon="['fass', 'star']" />
          Reviews
        </a>
      </li>
      <li class="text-white hover:bg-primary-color hover:bg-opacity-75 p-2 hover:cursor-pointer">
        <a class="link" to="#">
            <font-awesome-icon :icon="['fass', 'users']" />
          Profiles
        </a>
      </li>

      <li class="text-white hover:bg-primary-color hover:bg-opacity-75 p-2 hover:cursor-pointer">
        <router-link class="link" :to="{name: 'stats', params: {room: 'chaturbate-most-followed'}}">
            <font-awesome-icon :icon="['fass', 'chart-bar']" />
          Stats
        </router-link>
      </li>
      <li class="text-white hover:bg-primary-color hover:bg-opacity-75 p-2 hover:cursor-pointer">
        <a class="link" href="#">
            <font-awesome-icon :icon="['fass', 'address-book']" />
          Contact
        </a>
      </li>
      <li class="text-white hover:bg-primary-color hover:bg-opacity-75 p-2 hover:cursor-pointer">
        <router-link class="link" :to="{name: 'login'}">
            <font-awesome-icon :icon="['fass', 'sign-in-alt']" />
          Account
        </router-link>
      </li>
      <li class="text-white hover:bg-primary-color hover:bg-opacity-75 p-2 hover:cursor-pointer">
        <router-link class="link" :to="{name: 'register'}">
            <font-awesome-icon :icon="['fass', 'user-plus']" />
          Sign in
        </router-link>
      </li>
    </ul>
  </nav>
</template>

<script setup>
defineProps({
    expanded: {
        type: Boolean,
        required: true,
    },
});

</script>

<style lang="postcss">
.a {
  @apply px-5 py-3 flex items-center gap-3 transition-all text-white hover:bg-[#252526];
}
</style>
