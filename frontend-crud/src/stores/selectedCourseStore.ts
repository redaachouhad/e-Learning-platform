import axiosInstance from "@/axios";
import type { Course } from "@/types/course";
import { defineStore } from "pinia";

export const useSelectedCourseStore = defineStore("selectedCourse", {
  state: (): {
    selectedCourse: Course | null;
    isLoadingCourses: boolean;
    isSuccessCourses: boolean;
    isEnrolled: boolean;
  } => {
    return {
      selectedCourse: null,
      isLoadingCourses: false,
      isSuccessCourses: false,
      isEnrolled: false,
    };
  },
  actions: {
    async fetchOneCourse(id: string) {
      this.isLoadingCourses = true;
      try {
        const response = await axiosInstance.get("/api/getOneCourse/" + id);
        this.isEnrolled = response.data.enroll;
        this.selectedCourse = response.data.course;
        this.isSuccessCourses = true;
      } catch (error) {
        this.selectedCourse = null;
        this.isSuccessCourses = false;
      } finally {
        this.isLoadingCourses = false;
      }
    },
    setIsEnrolledAndCountLearner(enroll: boolean, countLearner: number) {
      console.log(enroll);
      if (this.selectedCourse) {
        this.isEnrolled = enroll;
        this.selectedCourse.enrolled_users_count = countLearner;
      }
    },
  },
});
