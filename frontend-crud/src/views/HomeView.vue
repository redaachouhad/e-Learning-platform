<script setup lang="ts">
import { useAuthStore } from "@/stores/authStore";
import { onMounted } from "vue";

const authStore = useAuthStore();
onMounted(() => {
  authStore.fetchUser();
});
</script>

<template>
  <main></main>
</template>
