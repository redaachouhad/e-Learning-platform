<script setup lang="ts">
import type { Component } from "vue";

const props = defineProps<{
  icon: Component;
  name: string;
  clickFn: (type: string) => void;
  formType: string;
}>();
</script>

<template>
  <button
    @click="clickFn(name)"
    class="flex flex-row items-center p-3 gap-2 w-full cursor-pointer"
    :class="
      formType === name
        ? 'bg-blue-500 '
        : 'dark:hover:bg-gray-700 hover:bg-blue-200'
    "
  >
    <component
      :is="props.icon"
      class="h-8 w-8 text-black dark:text-white"
    ></component>
    <p class="text-gray-800 dark:text-white">{{ name }}</p>
  </button>
</template>
