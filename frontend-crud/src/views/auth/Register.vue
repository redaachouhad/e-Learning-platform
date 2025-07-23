<script setup lang="ts">
import axiosInstance from "@/axios";
import CardAuthLayout from "@/components/CardAuthLayout.vue";
import IconSpinner from "@/components/icons/IconSpinner.vue";
import { AxiosError } from "axios";
import { reactive, ref } from "vue";
import { useRouter } from "vue-router";

interface RegisterForm {
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
}

interface ErrorForm {
  name: [];
  email: [];
  password: [];
}

// form data
const formData = reactive<RegisterForm>({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

// errors
const errors = reactive<ErrorForm>({
  name: [],
  email: [],
  password: [],
});

const loadingRegister = ref<boolean>(false);
const router = useRouter();

// Registering a new user
const register = async (data: RegisterForm) => {
  Object.assign(errors, {
    name: [],
    email: [],
    password: [],
  });
  loadingRegister.value = true;
  console.log("Registering User ...");
  try {
    // Ensure CSRF token is set
    // This is necessary for Laravel Sanctum to work properly
    await axiosInstance.get("/sanctum/csrf-cookie");

    await axiosInstance.post("/api/register", data);
    console.log("User registered successfully");
    router.push("/login");
  } catch (e) {
    // console.error("Registration failed:", e);
    if (e instanceof AxiosError && e.response && e.response.data) {
      // Handle validation errors
      const validationErrors = e.response.data.errors;
      console.log(validationErrors);
      if (validationErrors) {
        if (validationErrors.name) {
          errors.name =
            validationErrors.name.length > 0 ? validationErrors.name : [];
        }
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
    }

    console.error("Validation errors:", errors);
  }
  loadingRegister.value = false;
};
</script>

<template>
  <CardAuthLayout>
    <div class="flex-1 flex justify-center items-center">
      <form class="w-full p-8" @submit.prevent="register(formData)">
        <div
          class="text-black dark:text-white text-3xl flex justify-center items-center gap-3"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            class="size-10"
          >
            <path
              d="M5.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM2.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM18.75 7.5a.75.75 0 0 0-1.5 0v2.25H15a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H21a.75.75 0 0 0 0-1.5h-2.25V7.5Z"
            />
          </svg>

          <h1 class="text-center font-medium">Register</h1>
        </div>
        <br /><br />

        <!-- Name -->
        <div class="mb-5">
          <label
            for="name"
            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >Name</label
          >
          <input
            type="text"
            id="name"
            name="name"
            v-model="formData.name"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="John Doe"
          />
          <ul v-if="errors.name.length" class="list-disc list-inside">
            <li
              class="text-red-600 dark:text-red-500 text-sm italic"
              v-for="error in errors.name"
              :key="error"
            >
              {{ error }}
            </li>
          </ul>
        </div>

        <!-- Email -->
        <div class="mb-5">
          <label
            for="email"
            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >Email</label
          >
          <input
            type="email"
            id="email"
            name="email"
            v-model="formData.email"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Example: mail@mail.com"
          />
          <ul v-if="errors.email.length" class="list-disc list-inside">
            <li
              class="text-red-600 dark:text-red-500 text-sm italic"
              v-for="error in errors.email"
              :key="error"
            >
              {{ error }}
            </li>
          </ul>
        </div>

        <!-- Password -->
        <div class="mb-5">
          <label
            for="password"
            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >Password</label
          >
          <input
            type="password"
            id="password"
            name="password"
            v-model="formData.password"
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

        <!-- Password Confirmation -->
        <div class="mb-5">
          <label
            for="password_confirmation"
            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >Confirm Password</label
          >
          <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            v-model="formData.password_confirmation"
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

        <button
          type="submit"
          class="cursor-pointer flex flex-row items-center justify-center gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        >
          <template v-if="loadingRegister">
            <IconSpinner size="w-6 h-6" />
          </template>
          <p>Register</p>
        </button>
      </form>
    </div>
  </CardAuthLayout>
</template>
+
