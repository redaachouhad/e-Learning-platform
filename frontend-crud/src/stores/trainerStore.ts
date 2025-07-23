import axiosInstance from "@/axios";
import type { Course } from "@/types/course";
import type { User } from "@/types/user";
import { defineStore } from "pinia";

export const useTrainerStore = defineStore("trainer", {
  state: (): {
    trainer: User | null;
    courses: Course[];
    isLoadingTrainer: boolean;
    isSuccessTrainer: boolean;
    isFollowed: boolean;
    followersCount: number;
    followingsCount: number;
  } => {
    return {
      trainer: null,
      courses: [],
      isLoadingTrainer: false,
      isSuccessTrainer: false,
      isFollowed: false,
      followersCount: 0,
      followingsCount: 0,
    };
  },
  actions: {
    async fetchTrainerWithCourses(id: string) {
      this.isLoadingTrainer = true;
      try {
        const response = await axiosInstance.get(
          "/api/getCreatorWithCourse/" + id
        );

        this.courses = response.data.courses;
        this.trainer = response.data.creator;
        this.isFollowed = response.data.followed;
        this.isSuccessTrainer = true;
        this.followersCount = response.data.creator.followers_count;
        this.followingsCount = response.data.creator.followings_count;
      } catch (error) {
        console.error("Error fetching trainer with courses:", error);
        this.courses = [];
        this.trainer = null;
        this.isFollowed = false;
        this.isSuccessTrainer = false;
      } finally {
        this.isLoadingTrainer = false;
      }
    },
    async toggleFollowTrainer(followed_id: number) {
      try {
        const response = await axiosInstance.post("/api/toggleFollow", {
          followed_id: followed_id,
        });

        console.log(response.data);
        this.isFollowed = response.data.followed;
        this.followersCount = response.data.followers_count;
        this.followingsCount = response.data.followings_count;
      } catch (error) {
        console.log("error:", error);
      }
    },
  },
});
