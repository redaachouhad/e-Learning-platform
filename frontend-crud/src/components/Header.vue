<script setup lang="ts">
import { useAuthStore } from "@/stores/authStore";
import { ref } from "vue";
import { RouterLink, useRouter } from "vue-router";
import DropMenuItem from "./DropMenuItem.vue";
import Switcher from "./Switcher.vue";

defineProps<{}>();

const isMenuVisible = ref(false);
const isDropDown = ref(false);
const router = useRouter();

// visibility  User dropdown
const userDropDown = () => {
  isDropDown.value = !isDropDown.value;
  isMenuVisible.value = false;
};

const authStore = useAuthStore();
</script>

<template>
  <header class="shadow-black drop-shadow-md z-10 sticky top-0">
    <nav class="bg-slate-300 border-gray-200 dark:bg-gray-900">
      <div
        class="flex flex-wrap items-center justify-between mx-auto py-2 px-4"
      >
        <RouterLink
          to="/"
          class="flex items-center space-x-3 rtl:space-x-reverse"
        >
          <img
            src="https://flowbite.com/docs/images/logo.svg"
            class="h-8"
            alt="Flowbite Logo"
          />
          <span
            class="self-center text-xl md:text-2xl font-semibold whitespace-nowrap dark:text-white"
            >e-Learning App</span
          >
        </RouterLink>
        <div
          class="flex items-center md:order-2 space-x-1 md:space-x-2 rtl:space-x-reverse"
        >
          <!-- switcher between dark & light -->
          <Switcher />
          <!-- Loading  -->
          <template v-if="authStore.isLoading">
            <div
              class="px-3 py-1 text-xs font-medium leading-none text-center text-blue-800 bg-blue-200 rounded-full animate-pulse dark:bg-blue-900 dark:text-blue-200"
            >
              Loading...
            </div>
          </template>
          <!-- Avatar -->
          <template v-else-if="authStore.isAuthenticated">
            <div class="flex flex-col items-end">
              <img
                @click="userDropDown()"
                id="avatarButton"
                type="button"
                class="w-10 h-10 rounded-full cursor-pointer"
                src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                alt="User dropdown"
              />

              <!-- Dropdown menu -->
              <div
                v-show="isDropDown"
                id="userDropdown"
                class="absolute top-full z-10 bg-gray-100 divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600"
              >
                <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                  <div>{{ authStore.user?.name }}</div>
                  <div class="font-medium">{{ authStore.user?.email }}</div>
                </div>
                <ul
                  class="py-2 text-sm text-gray-700 dark:text-gray-200"
                  aria-labelledby="avatarButton"
                  @click="userDropDown"
                >
                  <DropMenuItem route-name="Courses" url="/?page=1" />
                  <DropMenuItem
                    route-name="Create Course"
                    url="/create-course"
                  />
                  <DropMenuItem route-name="Settings" url="/settings" />
                </ul>
                <div class="py-1" @click="userDropDown">
                  <button
                    @click="authStore.logout(router)"
                    class="w-full block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white cursor-pointer"
                  >
                    Sign out
                  </button>
                </div>
              </div>
            </div>
          </template>

          <!-- buttons login and sign up -->
          <template v-else-if="!authStore.isAuthenticated">
            <div>
              <RouterLink
                to="/login"
                class="text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 md:px-5 md:py-2.5 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800"
                >Login</RouterLink
              >
              <RouterLink
                to="/register"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 md:px-5 md:py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                >Sign up</RouterLink
              >
            </div>
          </template>
        </div>
      </div>
    </nav>
  </header>
</template>

<style scoped></style>
