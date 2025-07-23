<script setup lang="ts">
defineProps<{
  label: string;
  type: string;
  modelValue: string | number | Date | undefined | null;
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
    <input
      :type="type"
      :id="label"
      :value="modelValue"
      @input="(event) => emit('update:modelValue',   (event.target as HTMLInputElement).value)"
      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
      :placeholder="placeholder"
      required
    />
  </div>
</template>

<style scoped>
/* Hide spinner arrows for number input */

/* Chrome, Safari, Edge, Opera */
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type="datetime-local"]::-webkit-calendar-picker-indicator {
  filter: invert(1);
  cursor: pointer;
}
</style>
