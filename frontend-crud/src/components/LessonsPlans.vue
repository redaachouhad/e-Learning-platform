<script setup lang="ts">
import { ref } from "vue";
import ChevronDown from "./icons/ChevronDown.vue";
import ChevronUp from "./icons/ChevronUp.vue";

interface Course {
  imageUrl: string;
  title: string;
  description: string;
}

defineProps<{
  courseTable: Course[];
}>();

const showChevronDown = ref(false);

const handleShowChevronDown = () => {
  showChevronDown.value = !showChevronDown.value;
};
</script>
<template>
  <div class="border border-blue-400 rounded-lg overflow-hidden flex flex-col">
    <div class="flex justify-start items-center p-2 bg-[#090918]">
      <p class="font-semibold p-3">Lesson Plans</p>
    </div>
    <!-- chapiters -->
    <div class="flex flex-col w-full">
      <div
        v-for="(course, index) in courseTable"
        :key="index"
        v-show="index < 1 || !showChevronDown"
        class="border border-gray-500 p-2 flex flex-row gap-4"
      >
        <img
          :src="course.imageUrl"
          alt=" course url image"
          class="w-16 rounded-lg border border-gray-500"
        />
        <div class="flex flex-col items-start justify-center w-full">
          <p class="text-blue-400 cursor-pointer">{{ course.title }}</p>
          <p class="text-xs">{{ course.description }}</p>
        </div>
      </div>
    </div>
    <div class="flex justify-end items-center p-3 bg-[#090918] text-blue-500">
      <button
        @click="handleShowChevronDown"
        class="cursor-pointer flex flex-row items-center border-2 border-blue-500 p-1 rounded-lg"
      >
        <p class="font-semibold text-sm">
          {{ showChevronDown ? "See More" : "See Less" }}
        </p>
        <ChevronDown v-if="showChevronDown" />
        <ChevronUp v-else />
      </button>
    </div>
  </div>
</template>
