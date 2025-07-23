import axiosInstance from "@/axios";
import type { User } from "@/types/user";
import { defineStore } from "pinia";
import type { Router } from "vue-router";

export const useAuthStore = defineStore("auth", {
  state: (): {
    user: User | null;
    isAuthenticated: boolean;
    isLoading: boolean;
  } => {
    return {
      user: null,
      isAuthenticated: false,
      isLoading: false,
    };
  },
  actions: {
    async fetchUser() {
      this.isLoading = true;
      try {
        await axiosInstance.get("/sanctum/csrf-cookie");
        const response = await axiosInstance.get("/api/user");
        this.user = response.data;
        this.isAuthenticated = true;
        console.log(this.user);
      } catch (error) {
        this.user = null;
        this.isAuthenticated = false;
      } finally {
        this.isLoading = false;
      }
    },
    async logout(router: Router) {
      if (!this.isAuthenticated) {
        if (router.currentRoute.value.path !== "/login") {
          router.push("/login");
        }
        return;
      }

      try {
        await axiosInstance.post("/api/logout");
        localStorage.removeItem("filters");
      } catch (error) {
        console.error("Logout failed:", error);
      } finally {
        this.user = null;
        this.isAuthenticated = false;
        this.isLoading = false;

        // ✅ Prevent redirect if already on login page
        if (router.currentRoute.value.path !== "/login") {
          router.push("/login");
        }
      }
    },
  },
});
