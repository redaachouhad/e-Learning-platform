<script setup lang="ts">
import { useRoute } from "vue-router";

defineProps<{
  path: string;
  name: string;
}>();

const route = useRoute();
</script>

<template>
  <RouterLink
    :to="path"
    class="block py-2 px-3 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700"
    :class="
      path === route.path
        ? 'text-blue-600 dark:text-blue-500'
        : 'text-black dark:text-white'
    "
    >{{ name }}</RouterLink
  >
</template>

<style scoped></style>
