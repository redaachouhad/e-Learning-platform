<script setup lang="ts">
import axiosInstance from "@/axios";
import { AxiosError } from "axios";
import { reactive, ref } from "vue";
import { useToast } from "vue-toastification";
import IconSpinner from "./icons/IconSpinner.vue";

const data = reactive({
  current_password: "",
  password: "",
  password_confirmation: "",
  message: "",
});

const errors = reactive({
  current_password: [],
  password: [],
  password_confirmation: [],
});

const loading = ref<boolean>(false);
const toast = useToast();

const updatePassword = async () => {
  Object.assign(errors, {
    current_password: [],
    password: [],
    password_confirmation: [],
  });
  data.message = "";

  const formData = new FormData();
  formData.append("current_password", data.current_password);
  formData.append("password", data.password);
  formData.append("password_confirmation", data.password_confirmation);

  try {
    loading.value = true;
    // Ensure CSRF token is set
    // This is necessary for Laravel Sanctum to work properly
    await axiosInstance.get("/sanctum/csrf-cookie");

    // Update Password
    const response = await axiosInstance.put("api/user/password", formData);

    if (response.status === 200) {
      data.message = "✅ Your Password is successfully updated";
      console.log(data.message);
    }

    data.password = "";
    data.current_password = "";
    data.password_confirmation = "";

    toast.success("The password is changed successfully");
    setTimeout(() => {
      data.message = "";
    }, 5000);
  } catch (e) {
    console.error("Updating Password Error: ", e);
    if (e instanceof AxiosError && e.response && e.response.data) {
      // Handle validation errors
      const validationErrors = e.response.data.errors;

      if (validationErrors) {
        if (validationErrors.current_password) {
          errors.current_password =
            validationErrors.current_password.length > 0
              ? validationErrors.current_password
              : [];
        }

        if (validationErrors.password) {
          errors.password =
            validationErrors.password.length > 0
              ? validationErrors.password
              : [];
        }
      }
    }
  } finally {
    loading.value = false;
  }
};
</script>
<template>
  <div class="w-[80%] m-10">
    <h1 class="dark:text-white text-3xl">Change Password:</h1>
    <br /><br /><br />

    <form @submit.prevent="updatePassword">
      <div class="mb-5">
        <label
          for="current_password"
          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
          >Current Password</label
        >
        <input
          type="password"
          id="current_password"
          v-model="data.current_password"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        />
        <ul v-if="errors.current_password.length" class="list-disc list-inside">
          <li
            class="text-red-600 dark:text-red-500 text-sm italic"
            v-for="error in errors.current_password"
            :key="error"
          >
            {{ error }}
          </li>
        </ul>
      </div>

      <div class="mb-5">
        <label
          for="password"
          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
          >New Password</label
        >
        <input
          type="password"
          id="password"
          v-model="data.password"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        />
        <ul v-if="errors.password.length" class="list-disc list-inside">
          <li
            class="text-red-600 dark:text-red-500 text-sm italic"
            v-for="error in errors.password"
            :key="error"
          >
            {{ error }}
          </li>
        </ul>
      </div>

      <div class="mb-5">
        <label
          for="password_confirmation"
          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
          >Confirm New Password</label
        >
        <input
          type="password"
          id="password_confirmation"
          v-model="data.password_confirmation"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        />
      </div>

      <button
        type="submit"
        class="flex flex-row justify-center items-center gap-2 cursor-pointer mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
      >
        <IconSpinner size="h-6 h-6" v-if="loading" />
        <p>Update Password</p>
      </button>

      <p class="text-green-400 my-4 font-medium">{{ data.message }}</p>
    </form>
  </div>
</template>
