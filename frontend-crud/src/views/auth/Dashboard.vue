<script setup lang="ts">
import CardCourse from "@/components/CardCourse.vue";
import Filter from "@/components/Filter.vue";
import IconClose from "@/components/icons/IconClose.vue";
import IconFilter from "@/components/icons/IconFilter.vue";
import IconGrid from "@/components/icons/IconGrid.vue";
import IconList from "@/components/icons/IconList.vue";
import IconSpinner from "@/components/icons/IconSpinner.vue";
import IconTitle from "@/components/icons/IconTitle.vue";
import IconUser from "@/components/icons/IconUser.vue";
import Pagination from "@/components/Pagination.vue";
import { useAuthStore } from "@/stores/authStore";

import { useCoursesStore } from "@/stores/coursesStore";
import { useFiltersStore } from "@/stores/filtersStore";
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";

const coursesStore = useCoursesStore();

const filters = [
  {
    name: "Rating",
    listName: ["4.5 & Up", "4.0 & Up", "3.5 & Up", "3.0 & Up"].map(
      (name, i) => ({ id: i + 1, name })
    ),
  },

  {
    name: "Enrolled Courses",
    listName: ["Show", "Don’t Show"].map((name, i) => ({
      id: i + 1,
      name,
    })),
  },
];

// list of filter ids.
const listOfFilters = ref<{
  searchTitle: string;
  searchAuthor: string;
  categoriesId: number[];
  proficienciesId: number[];
  languagesId: number[];
  pricingId: number[];
}>({
  searchTitle: "",
  searchAuthor: "",
  categoriesId: [],
  proficienciesId: [],
  languagesId: [],
  pricingId: [],
});

const filterStore = useFiltersStore();

//
const route = useRoute();

// fetching data: get list of courses
const fetchingCourses = async () => {
  await coursesStore.fetchCoursesWithPagination(
    route.query.page,
    listOfFilters.value
  );
};

// fetch courses with filters, pagination and searchFilter
const fetchingCoursesWithSearchFilter = async () => {
  localStorage.setItem("filters", JSON.stringify(listOfFilters.value));
  await coursesStore.fetchCoursesWithPagination(
    route.query.page,
    listOfFilters.value
  );
};
// get list of filters
const fetchingFilters = async () => {
  await filterStore.fetchFilters();
};

// get all data: filters and courses:
const fetchAllData = () => {
  const savedFilters = localStorage.getItem("filters");
  if (savedFilters) {
    listOfFilters.value = JSON.parse(savedFilters);
  } else {
    localStorage.setItem("filters", JSON.stringify(listOfFilters.value));
  }
  fetchingFilters();
  fetchingCourses();
};

const authStore = useAuthStore();

// fetching filters and courses
onMounted(() => {
  fetchAllData();
});

// reset filters
const resetFilters = async () => {
  Object.assign(listOfFilters.value, {
    categoriesId: [],
    proficienciesId: [],
    languagesId: [],
    pricingId: [],
  });
  localStorage.setItem("filters", JSON.stringify(listOfFilters.value));
  await fetchingCourses();
};

// reset searchTitle input
const resetSearchTitle = async () => {
  listOfFilters.value.searchTitle = "";
  localStorage.setItem("filters", JSON.stringify(listOfFilters.value));
  await coursesStore.fetchCoursesWithPagination(
    route.query.page,
    listOfFilters.value
  );
};

// reset searchAuthor input

const resetSearchAuthor = async () => {
  listOfFilters.value.searchAuthor = "";
  localStorage.setItem("filters", JSON.stringify(listOfFilters.value));
  await coursesStore.fetchCoursesWithPagination(
    route.query.page,
    listOfFilters.value
  );
};
</script>

<template>
  <template v-if="authStore.isLoading">
    <div class="w-full h-[54rem] flex justify-center items-center">
      <IconSpinner />
    </div>
  </template>
  <template v-else-if="!authStore.isLoading">
    <div class="flex justify-center rounded-lg h-[54rem]">
      <div class="w-full lg:w-[170vmin] flex flex-row p-4 gap-2">
        <!-- Filter Section-->
        <div
          class="border-r border-gray-600 w-[25%] block px-2 overflow-y-scroll scroll-box"
        >
          <div
            class="bg-[rgb(25,40,62)] w-full flex-1 rounded-lg flex flex-col"
          >
            <!-- title filter with button Reset -->
            <div class="flex flex-row justify-between items-center p-2">
              <p
                class="gap-2 text-black dark:text-white flex flex-row justify-center items-center"
              >
                <IconFilter />
                <span class="text-lg">Filter</span>
              </p>

              <button
                @click="resetFilters"
                type="button"
                class="cursor-pointer text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-1.5 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800"
              >
                Reset
              </button>
            </div>
            <div class="p-2 h-full">
              <Filter
                name="Category"
                :list-name="filterStore.categories"
                :listOfFilters="listOfFilters"
                :is-loading="filterStore.isLoadingCourses"
              />
              <Filter
                name="Proficiency"
                :list-name="filterStore.proficiencies"
                :listOfFilters="listOfFilters"
                :is-loading="filterStore.isLoadingCourses"
              />
              <Filter
                name="Language"
                :list-name="filterStore.languages"
                :listOfFilters="listOfFilters"
                :is-loading="filterStore.isLoadingCourses"
              />
              <Filter
                name="Pricing"
                :list-name="filterStore.pricing"
                :listOfFilters="listOfFilters"
                :is-loading="filterStore.isLoadingCourses"
              />
            </div>
          </div>
        </div>
        <!-- All Courses -->
        <div
          class="flex-1 flex flex-col justify-between overflow-y-scroll pr-4 scroll-box"
        >
          <!-- Header for searching course -->
          <div class="bg-[rgb(28,50,81)] rounded-md">
            <!-- image and title -->
            <div class="flex flex-row justify-between">
              <h1 class="p-4 text-2xl text-black dark:text-white">
                All Courses
              </h1>
              <img src="/images/corner-6.png" alt="" class="h-18" />
            </div>

            <!-- search bar -->
            <div class="p-4 flex flex-row justify-between items-center">
              <div class="flex flex-row items-center gap-2">
                <div class="flex flex-row items-center gap-3">
                  <IconFilter class="hidden" />
                  <div
                    class="border border-white bg-[rgb(255,255,255)] flex flex-row items-center py-1 px-2 rounded-full"
                  >
                    <IconTitle class="text-black" />
                    <input
                      type="text"
                      class="p-1 text-sm outline-none min-w-[15rem]"
                      v-model="listOfFilters.searchTitle"
                      placeholder="Search title ..."
                    />
                    <button
                      class="cursor-pointer"
                      v-if="listOfFilters.searchTitle"
                      @click="resetSearchTitle"
                    >
                      <IconClose />
                    </button>
                  </div>
                  <div
                    class="border border-white bg-[rgb(255,255,255)] flex flex-row items-center py-1 px-2 rounded-full"
                  >
                    <IconUser class="text-black" />
                    <input
                      type="text"
                      class="p-1 text-sm outline-none min-w-[15rem]"
                      v-model="listOfFilters.searchAuthor"
                      placeholder="Search author ..."
                    />
                    <button
                      class="cursor-pointer"
                      v-if="listOfFilters.searchAuthor"
                      @click="resetSearchAuthor"
                    >
                      <IconClose />
                    </button>
                  </div>
                </div>
                <button
                  @click="fetchingCoursesWithSearchFilter"
                  class="text-white text-sm bg-blue-500 hover:bg-blue-600 p-2 rounded-md cursor-pointer"
                >
                  Search
                </button>
              </div>

              <div class="flex flex-row items-center gap-3">
                <select
                  name="filter"
                  id="filter"
                  class="bg-[rgba(255,255,255,0.8)] px-3 py-0.5 rounded-lg"
                >
                  <option disabled selected class="bg-white">
                    Select filter
                  </option>
                  <option value="rate" class="bg-white">Rate</option>
                  <option value="review" class="bg-white">Review</option>
                  <option value="price" class="bg-white">Price</option>
                </select>
                <IconList />
                <IconGrid />
              </div>
            </div>
          </div>

          <!-- Pagination -->

          <template v-if="!coursesStore.isLoadingCourses">
            <Pagination
              :currentPage="coursesStore.paginationCourses?.current_page"
              :links="coursesStore.paginationCourses?.links"
              :lastPage="coursesStore.paginationCourses?.last_page"
              :listOfFilters="listOfFilters"
            />
          </template>

          <!-- list/grid of course -->
          <div class="flex-1">
            <!-- one card -->
            <template
              v-if="!coursesStore.isLoadingCourses"
              v-for="(item, index) in coursesStore.paginationCourses?.data"
              :key="item.id"
            >
              <CardCourse :course="item" />
            </template>

            <template v-else>
              <div
                class="w-full h-full flex justify-center items-center rounded-lg shadow-md bg-gray-900 py-2"
              >
                <IconSpinner />
              </div>
            </template>
          </div>

          <!-- Pagination -->
          <template v-if="!coursesStore.isLoadingCourses">
            <Pagination
              :currentPage="coursesStore.paginationCourses?.current_page"
              :links="coursesStore.paginationCourses?.links"
              :lastPage="coursesStore.paginationCourses?.last_page"
              :listOfFilters="listOfFilters"
            />
          </template>
        </div>
      </div>
    </div>
  </template>
</template>

<style scoped>
.image-container {
  background-image: url("/images/course1.png");
  background-position: center;
  background-size: cover;
}

.scroll-box::-webkit-scrollbar {
  width: 8px;
}

.scroll-box::-webkit-scrollbar-thumb {
  background-color: #2563eb; /* blue-600 */
  border-radius: 10px;
}

.scroll-box::-webkit-scrollbar-track {
  background-color: #e5e7eb; /* gray-200 */
  border-radius: 50rem;
}
</style>
