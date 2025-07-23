<script setup lang="ts">
import type { Course } from "@/types/course";
import CourseCardByTrainer from "./CourseCardByTrainer.vue";

defineProps<{ coursesOfTrainer: Course[]; nameTrainer: string }>();
</script>
<template>
  <div class="border-2 border-blue-500 mt-6 rounded-xl overflow-hidden">
    <p class="p-4 text-lg bg-[rgb(11,9,33)]">
      Other Courses by
      <span class="text-blue-400 font-medium"> {{ nameTrainer }}</span>
    </p>
    <div class="grid grid-cols-3 p-4 gap-6">
      <template v-for="(item, index) in coursesOfTrainer" :key="index">
        <CourseCardByTrainer :course-of-trainer="item" />
      </template>
    </div>
  </div>
</template>
