<script setup lang="ts">
defineProps<{ routeName: string; url: string }>();
</script>
<template>
  <li>
    <RouterLink
      :to="url"
      class="block px-4 py-2 hover:bg-gray-200 dark:hover:bg-gray-600 dark:hover:text-white"
      >{{ routeName }}</RouterLink
    >
  </li>
</template>
<style scoped></style>
