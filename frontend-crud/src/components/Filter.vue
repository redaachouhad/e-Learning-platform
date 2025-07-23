<script setup lang="ts">
import { useCoursesStore } from "@/stores/coursesStore";
import type { Category } from "@/types/category";
import type { Language } from "@/types/language";
import type { Pricing } from "@/types/pricing";
import type { Proficiency } from "@/types/proficiency";
import { ref } from "vue";
import IconSpinner from "./icons/IconSpinner.vue";

const props = defineProps<{
  name: string;
  listName: Category[] | Language[] | Proficiency[] | Pricing[];
  listOfFilters: {
    searchTitle: string;
    searchAuthor: string;
    categoriesId: number[];
    proficienciesId: number[];
    languagesId: number[];
    pricingId: number[];
  };
  isLoading: boolean;
}>();

const showFilterDetails = ref(true);
const emit = defineEmits<{ (e: "add:id", id: number): void }>();

const handleShowFilterDetails = () => {
  showFilterDetails.value = !showFilterDetails.value;
};

// find the selected id
const isSelected = (listIds: number[], id: number): boolean => {
  return listIds.some((selectedId) => selectedId === id);
};

// fetching data: get list of courses
const coursesStore = useCoursesStore();
const fetchingCoursesWithPagination = async () => {
  await coursesStore.fetchCoursesWithPagination("1", props.listOfFilters);
};

// toggle function for id item of a list (list of numbers)
const toggleItem = async (list: number[], id: number) => {
  // toggle (add / delete) item from list
  const index = list.findIndex((item) => item === id);
  if (index === -1) {
    list.push(id);
  } else {
    list.splice(index, 1);
  }
  console.log(list);
  // persist filters
  localStorage.setItem("filters", JSON.stringify(props.listOfFilters));
  // fetching course only
  await fetchingCoursesWithPagination();
};

// toggle function for all ids in the same time from a list
const toggleAllItems = async (listTo: number[]) => {
  const length1 = props.listName.length;
  const length2 = listTo.length;

  // make listTo empty
  listTo.splice(0);

  // add all ids when the input:checkbox is checked
  if (length2 < length1) {
    listTo.push(...props.listName.map((item) => item.id));
  }

  // persist filters
  localStorage.setItem("filters", JSON.stringify(props.listOfFilters));

  // fetching course only
  await fetchingCoursesWithPagination();
};

//
const isAllSelected = (listTo: number[]) => {
  return props.listName.length === listTo.length;
};
</script>
<template>
  <div class="w-full flex flex-col gap-2">
    <div
      @click="handleShowFilterDetails"
      class="cursor-pointer w-full text-black dark:text-white flex flex-row justify-between items-center"
    >
      <p class="text-sm">{{ name }}</p>
      <p v-if="showFilterDetails" class="p-1">-</p>
      <p v-if="!showFilterDetails" class="p-1">+</p>
    </div>

    <div
      v-if="showFilterDetails"
      class="text-white flex flex-col text-sm gap-2 p-4"
    >
      <label
        v-if="!isLoading"
        class="flex flex-row w-full justify-between cursor-pointer italic"
      >
        <template v-if="name === 'Category'">
          <p class="underline">All Categories</p>
          <input
            type="checkbox"
            @change="toggleAllItems(props.listOfFilters.categoriesId)"
            :checked="isAllSelected(props.listOfFilters.categoriesId)"
          />
        </template>
        <template v-if="name === 'Pricing'">
          <p class="underline">All Pricing</p>
          <input
            type="checkbox"
            @change="toggleAllItems(props.listOfFilters.pricingId)"
            :checked="isAllSelected(props.listOfFilters.pricingId)"
          />
        </template>
        <template v-if="name === 'Proficiency'">
          <p class="underline">All Proficiencies</p>
          <input
            type="checkbox"
            @change="toggleAllItems(props.listOfFilters.proficienciesId)"
            :checked="isAllSelected(props.listOfFilters.proficienciesId)"
          />
        </template>
        <template v-if="name === 'Language'">
          <p class="underline">All Languages</p>
          <input
            type="checkbox"
            @change="toggleAllItems(props.listOfFilters.languagesId)"
            :checked="isAllSelected(props.listOfFilters.languagesId)"
          />
        </template>
      </label>

      <div
        v-if="!isLoading"
        v-for="(filter, index) in listName"
        :key="filter.id"
        class="flex flex-row justify-between items-center text-sm text-gray-300"
      >
        <label class="flex flex-row w-full justify-between cursor-pointer">
          <template v-if="name === 'Category'">
            <p>{{ (filter as Category).name }}</p>
            <input
              type="checkbox"
              :checked="isSelected(listOfFilters.categoriesId, (filter as Category).id as number )"
              @change="toggleItem(listOfFilters.categoriesId, filter.id)"
            />
          </template>

          <template v-if="name === 'Pricing'">
            <p>{{ (filter as Pricing).type }}</p>
            <input
              type="checkbox"
              :checked="isSelected(listOfFilters.pricingId, (filter as Pricing).id as number )"
              @change="toggleItem(listOfFilters.pricingId, filter.id)"
            />
          </template>

          <template v-if="name === 'Proficiency'">
            <p>{{ (filter as Proficiency).level }}</p>
            <input
              type="checkbox"
              :checked="isSelected(listOfFilters.proficienciesId, (filter as Proficiency).id as number )"
              @change="toggleItem(listOfFilters.proficienciesId, filter.id)"
            />
          </template>

          <template v-if="name === 'Language'">
            <p>{{ (filter as Language).name }}</p>
            <input
              type="checkbox"
              :checked="isSelected(listOfFilters.languagesId, (filter as Language).id as number )"
              @change="toggleItem(listOfFilters.languagesId, filter.id)"
            />
          </template>
        </label>
      </div>

      <div
        v-else
        class="text-white flex flex-col text-sm gap-2 p-2 w-full justify-center items-center"
      >
        <IconSpinner size="h-6 w-6" />
      </div>
    </div>

    <hr class="text-[rgba(255,255,255,0.3)] my-2" />
  </div>
</template>
