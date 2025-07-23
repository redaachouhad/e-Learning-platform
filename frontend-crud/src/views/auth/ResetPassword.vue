<script setup lang="ts">
import axiosInstance from "@/axios";
import CardAuthLayout from "@/components/CardAuthLayout.vue";
import IconSpinner from "@/components/icons/IconSpinner.vue";
import router from "@/router";
import { AxiosError } from "axios";
import { reactive, ref } from "vue";
import { useRoute } from "vue-router";
import { useToast } from "vue-toastification";

const toast = useToast();

// errors
const errors = reactive({
  password: [],
  password_confirmation: [],
  token: [],
  email: [],
});

const data = reactive({
  password: "",
  password_confirmation: "",
  message: "",
  error: "",
});

const route = useRoute();

const loading = ref<boolean>(false);

const forgotPassword = async () => {
  const formData = new FormData();
  formData.append("password", data.password);
  formData.append("password_confirmation", data.password_confirmation);
  formData.append("token", route.params.token as string);
  formData.append("email", route.query.email as string);

  try {
    loading.value = true;
    data.message = "";
    errors.password = [];
    errors.password_confirmation = [];
    // csrf
    await axiosInstance.get("/sanctum/csrf-cookie");
    const response = await axiosInstance.post("/api/reset-password", formData);
    console.log(response);
    data.message = response.data.message;
    toast.success(data.message, {
      timeout: 3000,
    });
    await startCountdown();
    router.push("/login");
  } catch (e) {
    console.error(e);
    if (e instanceof AxiosError && e.response && e.response.data) {
      // Handle validation errors
      const validationErrors = e.response.data.errors;
      if (validationErrors) {
        if (validationErrors.password) {
          errors.password =
            validationErrors.password.length > 0
              ? validationErrors.password
              : [];
        }
        if (validationErrors.password_confirmation) {
          errors.password_confirmation =
            validationErrors.password_confirmation.length > 0
              ? validationErrors.password_confirmation
              : [];
        }
        if (validationErrors.token) {
          errors.token =
            validationErrors.token.length > 0 ? validationErrors.token : [];
        }
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

// simple count down function
const count = ref<number>(0);
let interval: number | undefined;
function startCountdown(): Promise<void> {
  return new Promise((resolve) => {
    count.value = 5;

    interval = setInterval(() => {
      if (count.value > 0) {
        count.value--;
      } else {
        clearInterval(interval);
        resolve();
      }
    }, 1000);
  });
}
</script>

<template>
  <CardAuthLayout>
    <form @submit.prevent="forgotPassword" class="w-full p-6">
      <p class="text-white text-3xl mb-10">Reset Password</p>

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
          placeholder="New Password"
        />
      </div>

      <ul v-if="errors.password.length" class="list-disc list-inside">
        <li
          class="text-red-600 dark:text-red-500 text-sm italic"
          v-for="error in errors.password"
          :key="error"
        >
          {{ error }}
        </li>
      </ul>

      <div class="mb-5">
        <label
          for="password_confirmation"
          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
          >Password Confirmation</label
        >
        <input
          type="password"
          id="password_confirmation"
          v-model="data.password_confirmation"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
          placeholder="Password Confirmation"
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
      <ul v-if="errors.token.length" class="list-disc list-inside">
        <li
          class="text-red-600 dark:text-red-500 text-sm italic"
          v-for="error in errors.token"
          :key="error"
        >
          {{ error }}
        </li>
      </ul>
      <p class="text-green-400" v-if="data.message">✅ {{ data.message }}</p>
      <p class="text-green-400" v-if="data.message">
        ✅ You will be redirected to Login page in
        {{ count }} s
      </p>

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
