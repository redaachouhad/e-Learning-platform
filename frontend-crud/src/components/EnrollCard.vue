<script setup lang="ts">
import axiosInstance from "@/axios";
import { useSelectedCourseStore } from "@/stores/selectedCourseStore";

const props = defineProps<{
  cardEnrollContent: string[] | undefined;
  basedPrice: number | undefined | null;
  discountedPrice: number | undefined | null;
  discountEndDate: Date | undefined;
  courseId: number | undefined;
  userId: number | undefined;
}>();

// formatting date
const formattedDiscountEndDate = (date: string) => {
  return new Date(props.discountEndDate as Date).toLocaleString("en-US", {
    dateStyle: "long",
    timeStyle: "short",
  });
};

//  toggle enrollment (Enroll / Unenroll)
const enrollmentCourse = async () => {
  try {
    const response = await axiosInstance.post("/api/enrollmentToggle", {
      course_id: props.courseId,
      user_id: props.userId,
    });
    console.log(response.data.enrolled);
    courseStore.setIsEnrolledAndCountLearner(
      response.data.enrolled,
      response.data.count_learner
    );
  } catch (error) {
    console.log(error);
  }

  console.log(courseStore.isEnrolled);
  console.log(courseStore.selectedCourse?.enrolled_users_count);
};

// selected course
const courseStore = useSelectedCourseStore();
</script>

<template>
  <div class="sticky top-20 flex">
    <img
      src="/images/bg-wave.png"
      alt="wave"
      srcset=""
      class="absolute top-0 -right-21"
    />
    <div class="">
      <div
        class="w-full flex flex-col items-center rounded-lg overflow-hidden border border-red-400 shadow-md shadow-red-500 absolute"
      >
        <p class="p-3 bg-[#090918] w-full text-center">
          Plan Your Dream Career
        </p>
        <div class="bg-[rgb(24,37,82)] w-full p-4">
          <div class="flex flex-row items-end gap-2">
            <p class="text-3xl">
              ${{ courseStore.selectedCourse?.discounted_price }}
            </p>
            <p class="line-through text-md text-gray-400">
              ${{ courseStore.selectedCourse?.based_price }}
            </p>
          </div>

          <p class="text-sm text-red-500 mt-2">
            Sale ends in
            {{
              formattedDiscountEndDate(
                courseStore.selectedCourse?.discount_end_date as string
              )
            }}
          </p>

          <button
            v-if="!courseStore.isEnrolled"
            @click="enrollmentCourse"
            type="button"
            class="mt-2 cursor-pointer flex flex-row justify-center w-full text-white bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center items-center dark:focus:ring-[#4285F4]/55 me-2 mb-2"
          >
            Enroll
          </button>

          <button
            v-else
            @click="enrollmentCourse"
            type="button"
            class="cursor-pointer mt-2 w-full focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
          >
            Unenrolled
          </button>

          <p class="text-gray-400 text-xs mt-2">14 day Refund Policy</p>
          <hr class="text-gray-700 mt-2" />
          <p class="font-medium mt-2">Course Contents</p>
          <ul class="mt-2 text-white text-xs list-disc list-inside">
            <li v-for="(item, index) in cardEnrollContent" :key="index">
              {{ item }}
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped></style>
