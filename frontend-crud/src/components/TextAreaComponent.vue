<script setup lang="ts">
defineProps<{
  label: string;
  modelValue: string;
  placeholder: string;
}>();

const emit = defineEmits(["update:modelValue"]);
</script>
<template>
  <div class="mb-5">
    <label
      :for="label"
      class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
      >{{ label }} <span class="text-red-500">*</span></label
    >

    <textarea
      :id="label"
      :value="modelValue"
      @input="event =>emit('update:modelValue', (event.target as HTMLTextAreaElement).value)"
      rows="8"
      class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
      :placeholder="placeholder"
    ></textarea>
  </div>
</template>
<style scoped></style>
