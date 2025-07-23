<script setup lang="ts">
import { useCoursesStore } from "@/stores/coursesStore";
import { useRouter } from "vue-router";

const props = defineProps<{
  links: { url: string | null; label: string; active: boolean }[] | undefined;
  currentPage: number | undefined;
  lastPage: number | undefined;
  listOfFilters: {
    searchTitle: string;
    searchAuthor: string;
    categoriesId: number[];
    proficienciesId: number[];
    languagesId: number[];
    pricingId: number[];
  };
}>();

const coursesStore = useCoursesStore();
const router = useRouter();
const handleFetchCourses = (label: string) => {
  var page: number | string = 1;
  if (label.trim() === "&laquo; Previous") {
    page = (props.currentPage as number) - 1;
  } else if (label.trim() === "Next &raquo;") {
    page = (props.currentPage as number) + 1;
  } else {
    page = label;
  }
  coursesStore.fetchCoursesWithPagination(String(page), props.listOfFilters);
};
</script>
<template>
  <!-- Pagination -->
  <div
    class="flex space-x-2 bg-gray-900 p-4 rounded-md shadow-md justify-center my-2"
  >
    <button
      v-for="(link, index) in links"
      :key="index"
      :disabled="!link.url || link.active"
      v-html="link.label"
      :class="[
        'px-3 py-1 rounded-md border transition',
        link.active
          ? 'bg-blue-500 text-white cursor-pointer border-blue-500 '
          : 'bg-gray-800 text-gray-300 hover:bg-gray-700 border-gray-700',
        !link.url ? 'opacity-50 cursor-not-allowed' : '',
      ]"
      @click="handleFetchCourses(link.label)"
    ></button>
  </div>
</template>
<style scoped></style>
