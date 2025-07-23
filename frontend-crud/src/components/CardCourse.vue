<script setup lang="ts">
import type { Course } from "@/types/course";
import { useRouter } from "vue-router";
import IconArrowRight from "./icons/IconArrowRight.vue";
import IconHeart from "./icons/IconHeart.vue";
import IconStar from "./icons/IconStar.vue";

const props = defineProps<{ course: Course }>();

const router = useRouter();
</script>

<template>
  <div
    class="mb-4 flex justify-center items-center bg-[rgb(9,24,46)] rounded-xl overflow-hidden border-2 border-blue-400"
  >
    <div class="w-full flex flex-col lg:flex-row">
      <div
        v-if="course.image_url"
        :style="{
          backgroundImage: `url('${course.image_url.startsWith('https') ?(course.image_url as string):('http://localhost:8000/storage/' + course.image_url as string)}')`,
          backgroundSize: 'cover',
          backgroundPosition: 'center',
          backgroundRepeat: 'no-repeat',
        }"
      >
        <div class="lg:h-60 lg:w-72 w-full h-60"></div>
      </div>
      <div class="text-white text-sm p-4 w-full">
        <div class="flex flex-row gap-4 font-medium">
          <p class="text-xs bg-[rgb(53,57,91)] w-fit p-1 rounded-md border">
            {{ course.category.name }}
          </p>
          <p
            class="text-xs bg-[rgb(165,113,46)] w-fit p-1 rounded-md border border-yellow-300 text-yellow-300"
          >
            {{ course.proficiency.level }}
          </p>

          <p class="text-xs bg-[rgb(73,122,226)] w-fit p-1 rounded-md border">
            {{ course.language.name }}
          </p>
        </div>
        <br />
        <p
          class="text-lg text-blue-500 hover:text-blue-600 cursor-pointer mb-2 font-bold"
        >
          {{ course.creator.name }}
        </p>

        <p class="text-xl mb-2">
          {{ course.title }}
        </p>

        <p class="text-xs mb-2 line-clamp-2">
          {{ course.description }}
        </p>

        <div class="flex items-center">
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
      </div>
      <!-- Pricing  -->
      <div class="text-white text-sm p-4 flex justify-end items-center">
        <div
          class="h-full w-full lg:w-72 border border-[rgba(255,255,255,0.4)] flex flex-col justify-between rounded-lg p-3"
        >
          <!-- Price -->
          <div class="flex flex-col gap-2">
            <div class="flex flex-row items-center gap-2">
              <p class="text-3xl font-medium text-orange-400">
                ${{ course.discounted_price }}
              </p>

              <p class="line-through text-lg text-gray-400">
                ${{ course.based_price }}
              </p>
            </div>
            <p class="text-sm mb-2">
              {{ course.enrolled_users_count }} Learners Enrolled
            </p>
          </div>
          <!-- Buttons -->
          <div>
            <button
              class="w-full inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800"
            >
              <p
                class="cursor-pointer flex flex-row justify-center items-center gap-3 w-full px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-transparent group-hover:dark:bg-transparent"
              >
                <IconHeart />
                <span>Add To Whitelist</span>
              </p>
            </button>
            <button
              type="button"
              @click="
                () => {
                  router.push('/course/' + course.id);
                }
              "
              class="cursor-pointer gap-3 flex flex-row justify-center w-full text-white bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center items-center dark:focus:ring-[#4285F4]/55 me-2 mb-2"
            >
              <p>See More</p>
              <IconArrowRight />
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.image-container {
  background-position: center;
  background-size: cover;
}
</style>
