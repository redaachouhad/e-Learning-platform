<script setup lang="ts">
import axiosInstance from "@/axios";
import CardAuthLayout from "@/components/CardAuthLayout.vue";
import IconSpinner from "@/components/icons/IconSpinner.vue";
import { AxiosError } from "axios";
import { reactive, ref } from "vue";
import { useToast } from "vue-toastification";

const toast = useToast();

// errors
const errors = reactive({
  email: [],
});

const data = reactive({
  email: "",
  message: "",
  error: "",
});

const loading = ref<boolean>(false);

const forgotPassword = async () => {
  const formData = new FormData();
  formData.append("email", data.email);
  console.log(data.email);
  try {
    loading.value = true;
    data.message = "";
    errors.email = [];
    // csrf
    await axiosInstance.get("/sanctum/csrf-cookie");
    const response = await axiosInstance.post("/api/forgot-password", formData);
    console.log(response);
    data.message = response.data.message;
    toast.success(data.message, {
      timeout: 3000,
    });
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
      }
    }
  } finally {
    loading.value = false;
  }
};
</script>

<template>
  <CardAuthLayout>
    <form @submit.prevent="forgotPassword" class="w-full p-6">
      <p class="text-white text-3xl mb-10">Forgot Password</p>
      <p class="text-gray-400 mb-6">
        Enter your email and we'll send you a reset link.
      </p>
      <div class="mb-5">
        <label
          for="email"
          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
          >Email</label
        >
        <input
          type="email"
          id="email"
          v-model="data.email"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
          placeholder="name@flowbite.com"
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

      <p class="text-green-400" v-if="data.message">✅ {{ data.message }}</p>

      <button
        type="submit"
        class="my-6 flex flex-row items-center gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer"
      >
        <template v-if="loading">
          <IconSpinner size="w-6 h-6" />
        </template>
        <p>Send</p>
      </button>
    </form>
  </CardAuthLayout>
</template>
