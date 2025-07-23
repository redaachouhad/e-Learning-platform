<script setup lang="ts">
import { useSelectedCourseStore } from "@/stores/selectedCourseStore";
import type { Course } from "@/types/course";
import { onMounted, ref } from "vue";

defineProps<{
  id: number | undefined;
  name: string | undefined;
  profession: string | undefined;
  description: string | undefined;
}>();

const showFollow = ref(true);
const handleShowFollow = () => {
  showFollow.value = !showFollow.value;
};

const courseStore = useSelectedCourseStore();
const course = ref<Course | null>();
onMounted(() => {
  course.value = courseStore.selectedCourse;
});
</script>

<template>
  <div class="border border-blue-400 rounded-lg overflow-hidden flex flex-col">
    <div class="flex justify-between items-center p-3 bg-[#090918]">
      <p class="font-semibold">Trainer</p>
      <button
        v-if="showFollow"
        @click="handleShowFollow"
        class="text-blue-500 text-md border-2 border-blue-500 p-1 rounded-lg font-semibold cursor-pointer"
      >
        + Follow
      </button>
      <button
        v-else
        @click="handleShowFollow"
        class="text-red-500 text-md border-2 border-red-500 p-1 rounded-lg font-semibold cursor-pointer"
      >
        - Unfollow
      </button>
    </div>
    <div class="flex flex-row justify-between w-full relative p-5 gap-6">
      <div class="image-bg-1 absolute top-0 left-0 w-full h-full"></div>
      <div>
        <img
          src="/images/trainer.png"
          alt=""
          class="w-20 rounded-full border border-gray-400"
        />
      </div>
      <div class="flex-1 text-sm text-gray-300">
        <p class="text-lg text-blue-500">{{ course?.creator.name }}</p>
        <p>{{ "Artist" }}</p>

        <p class="text-sm text-gray-300 mt-4">
          {{ "ggggg" }}
        </p>
      </div>
    </div>
  </div>
</template>
<style scoped>
.image-bg-1 {
  background-image: url("/images/corner-7.png");
  background-size: contain;
  background-position: right;
  background-repeat: no-repeat;
}
</style>
