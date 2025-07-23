<script setup lang="ts">
import axiosInstance from "@/axios";
import CardCreateNewCourse from "@/components/CardCreateNewCourse.vue";
import CourseInformation from "@/components/CourseInformation.vue";
import IconSpinner from "@/components/icons/IconSpinner.vue";
import ImageUpload from "@/components/ImageUpload.vue";
import SetPricing from "@/components/SetPricing.vue";
import TableSection from "@/components/TableSection.vue";
import { useAuthStore } from "@/stores/authStore";
import { useFiltersStore } from "@/stores/filtersStore";
import { useSelectedCourseStore } from "@/stores/selectedCourseStore";
import type { Course } from "@/types/course";
import type { CourseInformationInterface } from "@/types/courseInformation";
import type { Price } from "@/types/price";
import { onMounted, reactive, ref, watch } from "vue";
import { useRoute, useRouter } from "vue-router";

const props = defineProps<{ mode: "editCourse" | "createCourse" }>();

// handling course information (name, description, category...)
const courseInformation = reactive<CourseInformationInterface>({
  title: "",
  category_id: 0,
  description: "",
  language_id: 0,
  proficiency_id: 0,
  pricing_id: 0,
});

// Price

const price = reactive<Price>({
  based_price: "",
  discounted_price: "",
  discount_start_date: null,
  discount_end_date: null,
});

// Requirement
const requirements = reactive({
  list: [] as string[],
});

// Goals
const goals = reactive({
  list: [] as string[],
});

// handle image of the course
const image = ref<File | null | string>(null);

// ////// Helper function //////// //
const authStore = useAuthStore();

const router = useRouter();

// get categories, proficiency, language, pricing from backen

const filtersStore = useFiltersStore();

// reset course information card
const handleResetCourseInformation = () => {
  courseInformation.title = "";
  courseInformation.description = "";
  courseInformation.category_id = 0;
  courseInformation.language_id = 0;
  courseInformation.proficiency_id = 0;
  courseInformation.pricing_id = 0;
};

// reset price
const handleResetPrice = () => {
  price.based_price = "";
  price.discounted_price = "";
  price.discount_start_date = new Date();
  price.discount_end_date = new Date();
};

// Helper function for table section

// reset table section
const resetListOfItems = (table: { list: string[] }) => {
  table.list = [];
};

// add table section
const handleAddItem = (table: { list: string[] }, newItem: string) => {
  table.list.push(newItem);
};

// delete table section
const handleDeleteItem = (table: { list: string[] }, index: number) => {
  table.list.splice(index, 1);
};

// updated table section
const handleUpdateItem = (
  table: { list: string[] },
  {
    index,
    updatedItem,
  }: {
    index: number;
    updatedItem: string;
  }
) => {
  table.list[index] = updatedItem;
};

// get the image from the UplaodImage component
const handleImage = (file: File) => {
  image.value = file;
};

// reset the value of the image
const resetImage = () => {
  image.value = null;
};

// to control the visibility of the spinner in the publish button
const loadingPublish = ref<boolean>(false);
const route = useRoute();
// Creating the course
const PublishingNewCourse = async () => {
  loadingPublish.value = true;
  const formData = new FormData();

  formData.append("user_id", String(authStore.user?.id));
  formData.append("title", courseInformation.title);
  formData.append("category_id", String(courseInformation.category_id));
  formData.append("description", courseInformation.description);
  formData.append("language_id", String(courseInformation.language_id));
  formData.append("proficiency_id", String(courseInformation.proficiency_id));
  formData.append("pricing_id", String(courseInformation.pricing_id));
  formData.append("based_price", price.based_price.toString());
  formData.append("discounted_price", price.discounted_price.toString());
  if (price.discount_start_date)
    formData.append(
      "discount_start_date",
      price.discount_start_date.toString()
    );
  if (price.discount_end_date)
    formData.append("discount_end_date", price.discount_end_date.toString());

  // Append goals
  goals.list.forEach((goal, i) => {
    formData.append(`goals[${i}]`, goal);
  });

  // Append requirements
  requirements.list.forEach((req, i) => {
    formData.append(`requirements[${i}]`, req);
  });

  // formData.append("_method", "PUT");

  // Image
  if (image.value) {
    if (image.value instanceof File) {
      formData.append("image", image.value);
    }
  }

  try {
    if (props.mode === "createCourse") {
      const response = await axiosInstance.post(
        "/api/createNewCourse",
        formData,
        {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        }
      );
      const resCourse: Course = response.data.course;
      router.push("/course/" + resCourse.id);
    } else if (props.mode === "editCourse") {
      formData.append("_method", "put");
      const response = await axiosInstance.post(
        "/api/editCourse/" + route.params.id,
        formData,
        {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        }
      );
      const resCourse: Course = response.data.course;
      router.push("/course/" + resCourse.id);
    }
  } catch (error) {
    console.error("Upload error:", error);
  }
  loadingPublish.value = false;
};

const courseStore = useSelectedCourseStore();
// loading page
const loadingPage = ref<boolean>(false);
onMounted(async () => {
  loadingPage.value = true;
  await filtersStore.fetchFilters();
  if (props.mode === "editCourse") {
    await courseStore.fetchOneCourse(String(route.params.id));
    if (authStore.user?.id !== courseStore.selectedCourse?.user_id) {
      router.push("/");
    }
  }
  loadingPage.value = false;
});

// initlise the input with the information of course when mode == "editCourse"
watch(
  () => courseStore.selectedCourse,
  (selectedCourse) => {
    if (props.mode === "editCourse" && selectedCourse) {
      // console.log(selectedCourse);
      // course information
      courseInformation.title = selectedCourse.title;
      courseInformation.category_id = selectedCourse?.category_id as number;
      courseInformation.proficiency_id = selectedCourse?.proficiency
        .id as number;
      courseInformation.language_id = selectedCourse?.language.id as number;
      courseInformation.pricing_id = selectedCourse.pricing.id as number;
      courseInformation.description = selectedCourse.description as string;

      // requirement list
      requirements.list = selectedCourse.requirements as string[];

      //goals
      goals.list = selectedCourse.goals as string[];

      // price
      price.based_price = selectedCourse.based_price as number;
      price.discounted_price = selectedCourse.discounted_price as number;
      price.discount_start_date = formatDateForInput(
        new Date(selectedCourse.discount_start_date as string)
      );
      price.discount_end_date = formatDateForInput(
        new Date(selectedCourse.discount_end_date as string)
      );

      // image
      image.value = selectedCourse.image_url as string;
    }
  }
);

// format date and time for
function formatDateForInput(date: Date): string {
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, "0");
  const day = String(date.getDate()).padStart(2, "0");
  const hours = String(date.getHours()).padStart(2, "0");
  const minutes = String(date.getMinutes()).padStart(2, "0");
  return `${year}-${month}-${day}T${hours}:${minutes}`;
}
</script>
<template>
  <div
    class="w-full flex-1 flex flex-col items-center justify-start p-4 bg-[rgb(21,29,59)]"
  >
    <div
      v-if="loadingPage"
      class="w-full xl:w-[140vmin] flex-1 flex justify-center items-center"
    >
      <IconSpinner />
    </div>
    <div v-else class="w-full xl:w-[140vmin] flex flex-col sm:flex-row gap-4">
      <div class="flex flex-col gap-6 flex-2/3 p-2">
        <!-- Create A New Course Introduction -->
        <CardCreateNewCourse :mode="mode" />

        <!-- Course Information Card -->
        <CourseInformation
          :categories="filtersStore.categories"
          :proficiencies="filtersStore.proficiencies"
          :languages="filtersStore.languages"
          :pricing="filtersStore.pricing"
          :course-information="courseInformation"
          @resetCourseInformation="handleResetCourseInformation"
        />

        <!-- Requirements -->
        <TableSection
          label="Requirements"
          :list-of-items="requirements.list"
          @add:requirements="(newItem) => handleAddItem(requirements, newItem)"
          @delete:requirements="
            (index) => handleDeleteItem(requirements, index)
          "
          @update:requirements="(item) => handleUpdateItem(requirements, item)"
          @reset:requirements="() => resetListOfItems(requirements)"
        />

        <!-- Goals -->
        <TableSection
          label="Goals"
          :list-of-items="goals.list"
          @add:goals="(newItem) => handleAddItem(goals, newItem)"
          @delete:goals="(index) => handleDeleteItem(goals, index)"
          @update:goals="(item) => handleUpdateItem(goals, item)"
          @reset:goals="() => resetListOfItems(goals)"
        />
      </div>
      <div class="flex-1/3 p-2 text-white flex flex-col gap-8">
        <div class="sticky top-18 flex flex-col-reverse sm:flex-col gap-6">
          <!--  -->
          <!-- Button to Publish the new course  -->
          <!--  -->
          <div class="w-full border border-blue-500 rounded-lg overflow-hidden">
            <p class="text-lg p-3 bg-[rgb(14,16,31)]">Publish The Course</p>
            <div class="w-full p-4 flex justify-center bg-[rgb(33,32,47)]">
              <form action="" @submit.prevent="PublishingNewCourse">
                <button
                  type="submit"
                  class="flex flex-row items-center gap-2 bg-blue-500 py-1.5 px-6 rounded-md cursor-pointer font-semibold"
                >
                  <template v-if="loadingPublish">
                    <IconSpinner size="w-6 h-6" />
                  </template>
                  {{ mode === "createCourse" ? "Publish" : "Apply Changes" }}
                </button>
              </form>
            </div>
          </div>
          <!--  -->
          <!-- Upload image of the course -->
          <!--  -->
          <ImageUpload
            @update:image="handleImage"
            @reset:image="resetImage"
            :image="image"
          />
          <!--  -->
          <!-- Set Price -->
          <!--  -->
          <SetPricing :price="price" @reset-price="handleResetPrice" />
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped></style>
