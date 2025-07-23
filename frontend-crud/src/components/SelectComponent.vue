<script setup lang="ts">
interface Category {
  id: number;
  name: string;
}

defineProps<{
  listOfItem: any[];
  modelValue: number;
  label: string;
  placeholder: string;
}>();
const emit = defineEmits(["update:modelValue"]);
</script>

<template>
  <div class="mb-5">
    <label
      :for="label"
      class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
      ><p>{{ label }} <span class="text-red-500">*</span></p></label
    >
    <select
      @change="event => emit('update:modelValue', Number((event.target as HTMLSelectElement).value))"
      :id="label"
      :value="modelValue"
      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
    >
      <option value="0" disabled selected>{{ placeholder }}</option>
      <option v-for="item in listOfItem" :key="item.id" :value="item.id">
        <template v-if="label == 'Category' || label == 'Language'">
          {{ item.name }}</template
        >
        <template v-if="label == 'Proficiency'"> {{ item.level }}</template>
        <template v-if="label == 'Pricing'"> {{ item.type }}</template>
      </option>
    </select>
  </div>
</template>
