<script setup lang="ts">
import type { Component } from "vue";

interface Benefit {
  icon: Component;
  title: string;
  description: string;
}

defineProps<{
  benefits: Benefit[];
}>();
</script>
<template>
  <div class="border border-blue-400 rounded-lg flex flex-row p-4 gap-2">
    <div
      v-for="(item, index) in benefits"
      :key="index"
      class="flex flex-col gap-2"
    >
      <component :is="item.icon"></component>
      <p class="text-blue-400">{{ item.title }}</p>
      <p class="text-xs">
        {{ item.description }}
      </p>
    </div>
  </div>
</template>
