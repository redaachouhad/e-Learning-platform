<script setup lang="ts">
import axiosInstance from "@/axios";
import Benefits from "@/components/Benefits.vue";
import CardCourseLarge from "@/components/CardCourseLarge.vue";
import EnrollCard from "@/components/EnrollCard.vue";
import Goals from "@/components/Goals.vue";
import IconCible from "@/components/icons/IconCible.vue";
import IconCommunication from "@/components/icons/IconCommunication.vue";
import IconDelete from "@/components/icons/IconDelete.vue";
import IconEdit from "@/components/icons/IconEdit.vue";
import IconPercentage from "@/components/icons/IconPercentage.vue";
import IconSpinner from "@/components/icons/IconSpinner.vue";
import LessonsPlans from "@/components/LessonsPlans.vue";
import Requirement from "@/components/Requirement.vue";
import Reviews from "@/components/Reviews.vue";
import Trainer from "@/components/Trainer.vue";
import { useAuthStore } from "@/stores/authStore";
import { useSelectedCourseStore } from "@/stores/selectedCourseStore";
import { onMounted, ref } from "vue";
import { useRoute, useRouter } from "vue-router";

const courseTable = [
  {
    imageUrl: "/images/chapitre-1.png",
    title: "Intro",
    description: "Introduction and Course Objectives",
  },
  {
    imageUrl: "/images/chapitre-2.png",
    title: "Chapter 1",
    description: "Tools, nothing more, nothing less",
  },
  {
    imageUrl: "/images/chapitre-3.png",
    title: "Chapter 2",
    description: "Choosing the Right Tools",
  },
  {
    imageUrl: "/images/chapitre-4.png",
    title: "Chapter 3",
    description: "Getting Comfortable",
  },
  {
    imageUrl: "/images/chapitre-5.png",
    title: "Chapter 4",
    description: "Exploring Beyond Comfort",
  },
  {
    imageUrl: "/images/chapitre-1.png",
    title: "Chapitre 5",
    description: "Introduction and Course Objectives",
  },
];

const cardEnrollContent = [
  "Total 13 hours of video lectures",
  "12 premium article access",
  "11 downloadable resources",
  "Mobile, Tab or TV friendly content",
  "Certificate upon completion",
  "Lifetime permission to access",
];

const benefits = [
  {
    icon: IconCible,
    title: "Improve in A Purposed Manner",
    description:
      "Improve your skills by immersing yourself in a learning environment with professional instruction and limited access at a time.",
  },
  {
    icon: IconPercentage,
    title: "Get Exclusive Deals and Discounts",
    description:
      "Online discussion and crucial insights, Adobe vouchers, and more are all available solely to you and your fellow learners to get you going.",
  },
  {
    icon: IconCommunication,
    title: "Networking with Fellow Artists",
    description:
      "Learn, work together and connect with other learners tools like a common purpose Discord and Slack channel and showcase your works.",
  },
];

const selectedCourseStore = useSelectedCourseStore();
const route = useRoute();
const router = useRouter();
const showDeleteMessage = ref<boolean>(false);

// fetch selected course
const fetchSelectedCourse = () => {
  selectedCourseStore.fetchOneCourse(String(route.params.id));
};

// handle edit course:
const handleEditCourse = () => {
  router.push("/edit-course/" + route.params.id);
};

const responseDelete = ref<string>("");

// handle delete course
const handleDeleteCourse = async () => {
  loadingDelete.value = true;
  try {
    const response = await axiosInstance.delete(
      "/api/deleteCourse/" + route.params.id
    );
    responseDelete.value = response.data.message;

    await startCountdown();

    router.push({ path: "/", query: { page: "1" } });
  } catch (error) {
    console.log("Error", error);
  }
};

// show delete message
const handleShowDeleteMessage = () => {
  showDeleteMessage.value = true;
};

// hidden delete message
const handleHiddenDeleteMessage = () => {
  showDeleteMessage.value = false;
  responseDelete.value = "";
};

onMounted(() => {
  fetchSelectedCourse();
});

const count = ref(0);
let interval: number | undefined;

// simple count down function
function startCountdown(): Promise<void> {
  return new Promise((resolve) => {
    count.value = 5;

    interval = setInterval(() => {
      if (count.value > 0) {
        count.value--;
      } else {
        clearInterval(interval);
        resolve();
      }
    }, 1000);
  });
}

const authStore = useAuthStore();
const loadingDelete = ref<boolean>(false);
</script>

<template>
  <div
    class="w-full flex-1 flex flex-col items-center justify-start p-3 bg-[rgb(21,29,59)] relative"
  >
    <template v-if="selectedCourseStore.isLoadingCourses">
      <div
        class="w-full flex-1 flex justify-center items-center rounded-lg shadow-md bg-gray-900 py-2"
      >
        <IconSpinner />
      </div>
    </template>
    <template v-else>
      <div class="w-full lg:w-[100vmin] xl:w-[140vmin]">
        <!-- buttons (edit and delete) -->
        <template
          v-if="
            selectedCourseStore.selectedCourse?.user_id === authStore.user?.id
          "
        >
          <div
            class="w-full mb-2 text-white font-medium flex flex-row justify-end gap-5"
          >
            <button
              @click="handleEditCourse"
              class="bg-green-500 hover:bg-green-600 p-2 cursor-pointer rounded-md text-sm flex flex-row items-center gap-1.5"
            >
              <IconEdit />
              <p>Edit Course</p>
            </button>
            <button
              @click="handleShowDeleteMessage"
              class="bg-red-500 hover:bg-red-600 p-2 cursor-pointer rounded-md text-sm flex flex-row items-center gap-1.5"
            >
              <IconDelete />
              <p>Delete Course</p>
            </button>
          </div>
          <div
            v-if="showDeleteMessage"
            class="w-full lg:w-[100vmin] xl:w-[140vmin] rounded-md p-2 text-white bg-[rgb(7,7,10)] my-4 flex flex-col"
          >
            <div class="flex flex-row items-center justify-between">
              <p>You want to delete this course, Are you Sure ?</p>
              <div class="flex flex-row gap-4">
                <button
                  @click="handleDeleteCourse"
                  class="bg-blue-500 py-1.5 px-3 rounded-md cursor-pointer flex flex-row items-center gap-2"
                >
                  <IconSpinner size="h-4 w-4" v-if="loadingDelete" />
                  <p>Yes</p>
                </button>
                <button
                  @click="handleHiddenDeleteMessage"
                  class="bg-red-500 py-1.5 px-3 rounded-md cursor-pointer"
                >
                  No
                </button>
              </div>
            </div>
            <br v-if="responseDelete" />
            <p v-if="responseDelete" class="text-green-400 text-lg text-center">
              {{ responseDelete }} , you will redirect to course page in
              {{ count }} s
            </p>
          </div>
        </template>
        <!-- Course Introduction Card -->
        <CardCourseLarge />
        <div class="text-white mt-2 flex flex-row justify-center w-full gap-5">
          <!-- course description -->
          <div class="flex-4/6 py-6 flex flex-col gap-8">
            <!-- three Benefits -->
            <Benefits :benefits="benefits" />

            <!-- This Course will teach you -->
            <Goals :goals="selectedCourseStore.selectedCourse?.goals" />

            <!-- Requirements -->
            <Requirement
              :requirements="selectedCourseStore.selectedCourse?.requirements"
            />

            <!-- Lesson Plans -->
            <LessonsPlans :course-table="courseTable" />

            <!-- Trainer -->
            <Trainer
              :id="selectedCourseStore.selectedCourse?.creator.id"
              :name="selectedCourseStore.selectedCourse?.creator.name"
              description="gg"
              profession="hh"
            />

            <!-- Reviews -->
            <Reviews />
          </div>

          <!-- enroll card -->
          <div class="flex-1/6 relative pt-6">
            <EnrollCard
              :card-enroll-content="cardEnrollContent"
              :based-price="selectedCourseStore.selectedCourse?.based_price"
              :discounted-price="
                selectedCourseStore.selectedCourse?.discounted_price
              "
              :discount-end-date="
                selectedCourseStore.selectedCourse?.discount_end_date as Date
              "
              :course-id="selectedCourseStore.selectedCourse?.id as number"
              :user-id="authStore.user?.id as number"
            />
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<style scoped>
.image-bg {
  background-image: url("/images/bg-wave.png");
  background-size: cover;
  background-position: center;
}
</style>
