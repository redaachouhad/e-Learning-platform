import axiosInstance from "@/axios";
import type { Category } from "@/types/category";
import type { Language } from "@/types/language";
import type { Pricing } from "@/types/pricing";
import type { Proficiency } from "@/types/proficiency";
import { defineStore } from "pinia";

export const useFiltersStore = defineStore("filters", {
  state: (): {
    categories: Category[];
    proficiencies: Proficiency[];
    languages: Language[];
    pricing: Pricing[];
    isLoadingCourses: boolean;
    isSuccessCourses: boolean;
  } => {
    return {
      categories: [],
      proficiencies: [],
      languages: [],
      pricing: [],
      isLoadingCourses: false,
      isSuccessCourses: false,
    };
  },
  actions: {
    async fetchFilters() {
      this.isLoadingCourses = true;
      try {
        const response = await axiosInstance.get("/api/categories");

        this.categories = response.data.categories as Category[];
        this.proficiencies = response.data.proficiencies as Proficiency[];
        this.languages = response.data.languages as Language[];
        this.pricing = response.data.pricing as Pricing[];

        this.isSuccessCourses = true;
      } catch (error) {
        this.categories = [];
        this.isSuccessCourses = false;
      } finally {
        this.isLoadingCourses = false;
      }
    },
  },
});
