import axiosInstance from "@/axios";
import router from "@/router";
import type { Course } from "@/types/course";
import type { PaginatedResponse } from "@/types/paginatedResponse";
import { defineStore } from "pinia";
import type { LocationQueryValue } from "vue-router";

export const useCoursesStore = defineStore("paginationCourses", {
  state: (): {
    paginationCourses: PaginatedResponse<Course> | null;
    isLoadingCourses: boolean;
  } => {
    return {
      paginationCourses: null,
      isLoadingCourses: false,
    };
  },
  actions: {
    async fetchCoursesWithPagination(
      page: LocationQueryValue | LocationQueryValue[] | string,
      filters: {
        searchTitle: string;
        searchAuthor: string;
        categoriesId: number[];
        proficienciesId: number[];
        languagesId: number[];
        pricingId: number[];
      }
    ) {
      // start loading during the fetch
      this.isLoadingCourses = true;
      try {
        // creating query
        const query: Record<string, string> = {};

        if (page) query.page = page === undefined ? "1" : String(page);
        if (filters.searchTitle) {
          query.searchTitle = filters.searchTitle;
        }

        if (filters.searchAuthor) {
          query.searchAuthor = filters.searchAuthor;
        }

        if (filters.categoriesId.length > 0)
          query.categories = filters.categoriesId.join(",");
        if (filters.proficienciesId.length > 0)
          query.proficiencies = filters.proficienciesId.join(",");
        if (filters.languagesId.length > 0)
          query.languages = filters.languagesId.join(",");
        if (filters.pricingId.length > 0)
          query.pricing = filters.pricingId.join(",");

        // push to url + query
        router.push({
          path: "/",
          query: query,
        });

        // fetching course with pagination
        const response = await axiosInstance.post(
          "/api/getCourseUsingFilters?page=" + page,
          filters
        );
        //  response = await axiosInstance.post("/api/getCoursesUsingFilters?page=" + page);
        this.paginationCourses = response.data.courses;
      } catch (error) {
        console.log(error);
        this.paginationCourses = null;
      } finally {
        // loading is finish
        this.isLoadingCourses = false;
      }
    },
  },
});
