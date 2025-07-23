<script setup lang="ts">
import type { Course } from "@/types/course";
import { RouterLink } from "vue-router";

defineProps<{ courseOfTrainer: Course }>();
</script>
<template>
  <div class="bg-[rgb(18,18,23)] p-4 rounded-xl border border-gray-400">
    <div class="flex flex-col">
      <!-- image of the course -->
      <div
        v-if="courseOfTrainer.image_url"
        class="w-full h-60 rounded-xl"
        :style="{
          backgroundImage:  `url('${courseOfTrainer.image_url.startsWith('https') ?(courseOfTrainer.image_url as string):('http://localhost:8000/storage/' + courseOfTrainer.image_url as string)}')`,
          backgroundSize: 'cover',
          backgroundPosition: 'center',
          backgroundRepeat: 'no-repeat',
        }"
      ></div>

      <div class="mt-2">
        <RouterLink
          :to="`/course/${courseOfTrainer.id}`"
          class="text-lg font-medium hover:underline-light-200 hover:underline cursor-pointer"
        >
          {{ courseOfTrainer.title }}
        </RouterLink>
        <p class="text-blue-400 mt-2">{{ courseOfTrainer.creator.name }}</p>
        <div class="flex flex-row my-2 justify-start items-center gap-2">
          <p class="text-2xl text-orange-400">
            ${{ courseOfTrainer.discounted_price }}
          </p>
          <p class="line-through text-gray-400">
            ${{ courseOfTrainer.based_price }}
          </p>
        </div>
        <p class="text-xs text-gray-300">
          {{ courseOfTrainer.enrolled_users_count }} Enrolled
        </p>
      </div>
    </div>
  </div>
</template>
