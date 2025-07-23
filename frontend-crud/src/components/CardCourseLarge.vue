<script setup lang="ts">
import { useSelectedCourseStore } from "@/stores/selectedCourseStore";
import type { Course } from "@/types/course";
import { ref } from "vue";
import IconCompletion from "./icons/IconCompletion.vue";
import IconGraduation from "./icons/IconGraduation.vue";
import IconLanguage from "./icons/IconLanguage.vue";
import IconStar from "./icons/IconStar.vue";

const course = ref<Course | null>();
const courseStore = useSelectedCourseStore();

const showDescription = ref(false);
const handleShowDescription = () => {
  showDescription.value = !showDescription.value;
};
</script>

<template>
  <!-- Course Introduction Card -->
  <div
    class="image-background-container w-full p-4 flex flex-col rounded-lg gap-4"
  >
    <div class="flex flex-row justify-between gap-4">
      <div
        v-if="courseStore.selectedCourse?.image_url"
        class="flex-1/3 h-64 rounded-lg flex justify-center items-center overflow-hidden"
        :style="{
          backgroundImage: `url('${courseStore.selectedCourse?.image_url.startsWith('https') ?(courseStore.selectedCourse?.image_url as string):('http://localhost:8000/storage/' + courseStore.selectedCourse?.image_url as string)}')`,
          backgroundSize: 'cover',
          backgroundPosition: 'center',
          backgroundRepeat: 'no-repeat',
        }"
      ></div>
      <div class="flex-2/3 text-white">
        <p class="text-sm font-medium">
          A course by
          <RouterLink
            class="text-blue-400 text-lg font-medium hover:underline"
            :to="`/trainer-profile/${courseStore.selectedCourse?.creator.id}`"
            >{{ courseStore.selectedCourse?.creator.name }}</RouterLink
          >
        </p>

        <p class="text-3xl mt-2 font-semibold">
          {{ courseStore.selectedCourse?.title }}
        </p>
        <div class="flex items-center mt-2">
          <IconStar />
          <p class="ms-2 text-sm font-bold text-gray-900 dark:text-white">
            4.95
          </p>
          <span
            class="w-1 h-1 mx-1.5 bg-gray-500 rounded-full dark:bg-gray-400"
          ></span>
          <a
            href="#"
            class="text-sm font-medium text-gray-900 underline hover:no-underline dark:text-white"
            >73 reviews</a
          >
        </div>
        <div class="mt-2">
          <span :class="showDescription ? '' : 'line-clamp-2'">
            {{ courseStore.selectedCourse?.description }}
          </span>

          <span
            @click="handleShowDescription"
            class="text-sm text-blue-400 font-semibold cursor-pointer"
            >{{ showDescription ? "See Less" : "See More" }}</span
          >
        </div>
      </div>
    </div>
    <hr class="text-gray-400 rounded-1" />
    <div class="flex flex-row items-center text-white text-sm gap-6">
      <div class="flex flex-row justify-center items-center gap-1">
        <IconCompletion />
        <span>
          {{ courseStore.selectedCourse?.enrolled_users_count }} Learners</span
        >
      </div>
      <div class="flex flex-row justify-center items-center gap-1">
        <IconGraduation />
        <span>{{ courseStore.selectedCourse?.category.name }}</span>
      </div>

      <div class="flex flex-row justify-center items-center gap-1">
        <IconLanguage />
        <span>{{ courseStore.selectedCourse?.language.name }}</span>
      </div>

      <div class="flex flex-row justify-center items-center gap-1">
        <span class="bg-[rgb(56,58,190)] p-1 rounded-md border border-white">
          {{ courseStore.selectedCourse?.proficiency.level }}
        </span>
      </div>
      <div class="flex flex-row justify-center items-center gap-1"></div>
    </div>
  </div>
</template>

<style scoped>
.image-background-container {
  background-image: url("/images/course-details-bg.png");
  background-size: cover;
  background-position: center;
}
</style>
