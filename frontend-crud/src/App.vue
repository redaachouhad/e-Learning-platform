<script setup lang="ts">
import { RouterView } from "vue-router";
import Header from "./components/Header.vue";
import { useAuthStore } from "./stores/authStore";

const authStore = useAuthStore();
</script>

<template>
  <div class="min-h-screen flex flex-col">
    <!-- the header of the app -->
    <Header />

    <main class="flex-1 flex flex-col dark:bg-black">
      <RouterView />
    </main>
  </div>
</template>

<style scoped></style>
