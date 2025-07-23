<script setup lang="ts">
interface Introduction {
  title: string;
  description: string;
}

defineProps<{ introduction: Introduction }>();
</script>
<template>
  <div class="border-2 border-blue-500 rounded-xl overflow-hidden">
    <p class="p-4 text-lg bg-[rgb(11,9,33)]">{{ introduction.title }}</p>
    <p class="p-4 text-sm">{{ introduction.description }}</p>
  </div>
</template>
