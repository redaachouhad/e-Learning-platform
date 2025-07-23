import axios from "axios";
import router from "./router";
import { useAuthStore } from "./stores/authStore";

// Axios Config
const axiosInstance = axios.create({
  baseURL: "http://localhost:8000",
  withCredentials: true, // Allows cookies like XSRF-TOKEN and laravel_session
  withXSRFToken: true, // Automatically adds X-XSRF-TOKEN header
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

//Intercept every request and check if user is still authenticated
axiosInstance.interceptors.response.use(
  (response) => response,
  (error) => {
    const originalRequest = error.config;

    // Skip logout logic if the failed request is the login request
    if (
      error.response?.status === 401 &&
      !originalRequest.url.includes("/api/login") &&
      !originalRequest.url.includes("/api/logout")
    ) {
      const authStore = useAuthStore();
      authStore.logout(router);
    }

    return Promise.reject(error);
  }
);

export default axiosInstance;
