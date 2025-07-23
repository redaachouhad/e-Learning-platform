<script setup lang="ts">
import axiosInstance from "@/axios";
import CardAuthLayout from "@/components/CardAuthLayout.vue";
import IconLock from "@/components/icons/IconLock.vue";
import IconSpinner from "@/components/icons/IconSpinner.vue";
import { AxiosError } from "axios";
import { reactive, ref } from "vue";
import { useRouter } from "vue-router";

interface LoginForm {
  email: string;
  password: string;
}

interface ErrorForm {
  email: [];
  password: [];
}

// errors
const errors = reactive<ErrorForm>({
  email: [],
  password: [],
});

const formData = reactive<LoginForm>({
  email: "",
  password: "",
});

const router = useRouter();
const loadingLogin = ref<boolean>(false);

const login = async (data: LoginForm) => {
  loadingLogin.value = true;
  Object.assign(errors, {
    email: [],
    password: [],
  });
  try {
    // Ensure CSRF token is set
    // This is necessary for Laravel Sanctum to work properly
    await axiosInstance.get("/sanctum/csrf-cookie");

    // Send Login Request
    await axiosInstance.post("/api/login", data);
    console.log("User logged in successfully");
    await router.push("/?page=1"); // Redirect to dashboard after successful login
  } catch (e) {
    console.error("Login failed:", e);
    if (e instanceof AxiosError && e.response && e.response.data) {
      // Handle validation errors
      const validationErrors = e.response.data.errors;
      if (validationErrors) {
        if (validationErrors.email) {
          errors.email =
            validationErrors.email.length > 0 ? validationErrors.email : [];
        }
        if (validationErrors.password) {
          errors.password =
            validationErrors.password.length > 0
              ? validationErrors.password
              : [];
        }
      }
      loadingLogin.value = false;
    }
  }
};
</script>

<template>
  <CardAuthLayout>
    <div class="flex-1 flex flex-col justify-center items-center p-6">
      <form @submit.prevent="login(formData)" class="w-[90vmin] md:w-[60vmin]">
        <div
          class="text-black dark:text-white text-3xl flex justify-center items-center gap-3"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            className="size-1"
            class="size-10"
          >
            <path
              d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z"
            />
          </svg>

          <h1 class="text-center font-medium">Login</h1>
        </div>
        <br />
        <div class="mb-5">
          <label
            for="email"
            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >Email</label
          >
          <input
            type="email"
            id="email"
            v-model="formData.email"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="name@flowbite.com"
          />
        </div>
        <div class="mb-5">
          <label
            for="password"
            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >Password</label
          >
          <input
            type="password"
            id="password"
            v-model="formData.password"
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
        <ul v-if="errors.password.length" class="list-disc list-inside">
          <li
            class="text-red-600 dark:text-red-500 text-sm italic"
            v-for="error in errors.password"
            :key="error"
          >
            {{ error }}
          </li>
        </ul>

        <button
          type="submit"
          class="mt-4 flex flex-row items-center gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer"
        >
          <template v-if="loadingLogin">
            <IconSpinner size="w-6 h-6" />
          </template>
          <p>Login</p>
        </button>
      </form>
      <div class="flex items-start my-5 w-full justify-end">
        <p
          @click="
            () => {
              router.push('/forgot-password');
            }
          "
          to="/forgot-password"
          class="text-blue-500 hover:underline text-md cursor-pointer flex items-center gap-2"
        >
          <IconLock />
          <span>Forgot password ?</span>
        </p>
      </div>
    </div>
  </CardAuthLayout>
</template>
