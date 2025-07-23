<script setup lang="ts">
import type { Category } from "@/types/category";
import type { CourseInformationInterface } from "@/types/courseInformation";
import type { Language } from "@/types/language";
import type { Pricing } from "@/types/pricing";
import type { Proficiency } from "@/types/proficiency";
import InputComponent from "./InputComponent.vue";
import SelectComponent from "./SelectComponent.vue";
import TextAreaComponent from "./TextAreaComponent.vue";

const props = defineProps<{
  categories: Category[];
  proficiencies: Proficiency[];
  languages: Language[];
  pricing: Pricing[];
  courseInformation: CourseInformationInterface;
}>();

const emit = defineEmits(["resetCourseInformation"]);
const handleResetCourseInformation = () => {
  emit("resetCourseInformation");
};
</script>
<template>
  <div class="border border-blue-500 rounded-lg overflow-hidden text-white">
    <div
      class="text-xl p-4 bg-[rgb(8,12,32)] flex flex-row w-full justify-between items-center"
    >
      <p>Course Information</p>
      <button
        @click="handleResetCourseInformation"
        class="text-sm bg-blue-500 py-1.5 px-3 rounded-lg cursor-pointer"
      >
        Reset
      </button>
    </div>
    <div class="p-4 bg-[rgb(33,32,47)] text-sm">
      <!-- Input for course title -->
      <InputComponent
        label="Course Title"
        type="text"
        v-model="courseInformation.title"
        placeholder="Course title ..."
      />

      <!-- Select for category -->
      <SelectComponent
        v-model="courseInformation.category_id"
        label="Category"
        :listOfItem="categories"
        placeholder="Select a category"
      />

      <!-- Select for Proficiencies -->
      <SelectComponent
        v-model="courseInformation.proficiency_id"
        label="Proficiency"
        :listOfItem="proficiencies"
        placeholder="Select a Level"
      />

      <!-- Select for Languages -->
      <SelectComponent
        v-model="courseInformation.language_id"
        label="Language"
        :listOfItem="languages"
        placeholder="Select a Language"
      />

      <!-- Select for Pricing -->
      <SelectComponent
        v-model="courseInformation.pricing_id"
        label="Pricing"
        :listOfItem="pricing"
        placeholder="Select a Pricing Type"
      />

      <!-- Description of course -->
      <TextAreaComponent
        label="Course Description"
        v-model="courseInformation.description"
        placeholder="Course Description here ..."
      />
    </div>
  </div>
</template>
