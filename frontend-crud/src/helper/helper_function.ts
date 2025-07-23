import axiosInstance from "@/axios";
import router from "@/router";

export async function checkAuth() {
  try {
    // Call your API endpoint that returns user info if authenticated
    await axiosInstance.get("/api/user");
    // then continue
  } catch (error: any) {
    if (error.response?.status === 401) {
      // Not authenticated => redirect to login page
      router.push("/login");
    }
    // For other errors, optionally throw or handle differently
    throw error;
  }
}
