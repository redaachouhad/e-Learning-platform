<script setup lang="ts">
import axiosInstance from "@/axios";
import { useAuthStore } from "@/stores/authStore";
import { AxiosError } from "axios";
import { onMounted, reactive, ref } from "vue";
import { useToast } from "vue-toastification";
import IconSpinner from "./icons/IconSpinner.vue";

const authStore = useAuthStore();
const isLoading = ref<boolean>(false);

const data = reactive({
  email: "",
  name: "",
});

// errors
const errors = reactive({
  email: [],
  name: [],
});

// success
const message = ref<string>();

// taostification
const toast = useToast();

const updateUserInfo = async () => {
  isLoading.value = true;
  Object.assign(errors, {
    email: [],
    name: [],
  });
  const formData = new FormData();
  formData.append("name", data.name);
  formData.append("email", data.email);

  try {
    // Ensure CSRF token is set
    // This is necessary for Laravel Sanctum to work properly
    await axiosInstance.get("/sanctum/csrf-cookie");

    // Send Update Info Request
    const response = await axiosInstance.put(
      "/api/user/profile-information",
      formData
    );
    if (response.status === 200) {
      message.value = "Information updated successfully";
      toast.success(message.value);
      setTimeout(() => {
        message.value = "";
      }, 5000);
    }
  } catch (e) {
    console.error(e);
    if (e instanceof AxiosError && e.response && e.response.data) {
      // Handle validation errors
      const validationErrors = e.response.data.errors;
      if (validationErrors) {
        if (validationErrors.email) {
          errors.email =
            validationErrors.email.length > 0 ? validationErrors.email : [];
        }
        if (validationErrors.name) {
          errors.name =
            validationErrors.name.length > 0 ? validationErrors.name : [];
        }
      }
    }
  } finally {
    isLoading.value = false;
  }
};

onMounted(() => {
  if (authStore.user) {
    data.name = authStore.user?.name as string;
    data.email = authStore.user?.email as string;
  }
});
</script>
<template>
  <div class="w-[80%] m-10">
    <h1 class="dark:text-white text-3xl">User Information:</h1>
    <br /><br /><br />

    <form @submit.prevent="updateUserInfo">
      <div class="mb-5">
        <label
          for="name"
          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
          >Name</label
        >
        <input
          type="text"
          id="name"
          v-model="data.name"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        />
      </div>

      <div class="mb-5">
        <label
          for="email"
          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
          >Email</label
        >
        <input
          type="text"
          id="email"
          v-model="data.email"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        />
      </div>
      <ul v-if="errors.email.length" class="list-disc list-inside">
        <li
          class="text-red-600 dark:text-red-500 text-sm italic"
          v-for="error in errors.email"
          :key="error"
        >
          {{ error }}
        </li>
      </ul>
      <ul v-if="errors.name.length" class="list-disc list-inside">
        <li
          class="text-red-600 dark:text-red-500 text-sm italic"
          v-for="error in errors.name"
          :key="error"
        >
          {{ error }}
        </li>
      </ul>
      <p class="my-3 text-green-500">{{ message }}</p>
      <button
        :disabled="
          authStore.user?.name === data.name &&
          authStore.user.email === data.email
        "
        type="submit"
        class="disabled:bg-blue-400 disabled:hover:bg-blue-400 flex flex-row items-center gap-3 cursor-pointer mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
      >
        <template v-if="isLoading">
          <IconSpinner size="h-5 w-5" />
        </template>
        <span> Save</span>
      </button>
    </form>
  </div>
</template>
