<script setup lang="ts">
import { ref, watchEffect } from "vue";

const isDark = ref(false);
const html = document.documentElement;

//  switcher between dark and light
const switcher = () => {
  const currentTheme = localStorage.theme;
  if (currentTheme === "dark") {
    html.classList.remove("dark");
    localStorage.theme = "light";
    isDark.value = false;
  } else {
    html.classList.add("dark");
    localStorage.theme = "dark";
    isDark.value = true;
  }
};

// Ensure theme is restored on page load
watchEffect(() => {
  const currentTheme = localStorage.theme;
  if (currentTheme === "light") {
    html.classList.remove("dark");
    localStorage.theme = "light";
    isDark.value = false;
  } else {
    html.classList.add("dark");
    localStorage.theme = "dark";
    isDark.value = true;
  }
});
</script>

<template>
  <button
    @click="switcher"
    class="text-gray-800 dark:text-white hover:bg-gray-50 font-medium rounded-lg text-md px-4 py-2 md:px-5 md:py-2.5 dark:hover:bg-gray-700 flex flex-row justify-center items-center gap-1"
  >
    <svg
      v-show="isDark"
      id="theme-toggle-dark-icon"
      class="w-5 h-5"
      fill="currentColor"
      viewBox="0 0 20 20"
      xmlns="http://www.w3.org/2000/svg"
    >
      <path
        d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"
      ></path>
    </svg>
    <svg
      v-show="!isDark"
      id="theme-toggle-light-icon"
      class="w-5 h-5"
      fill="currentColor"
      viewBox="0 0 20 20"
      xmlns="http://www.w3.org/2000/svg"
    >
      <path
        d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
        fill-rule="evenodd"
        clip-rule="evenodd"
      ></path>
    </svg>
  </button>
</template>

<style scoped></style>
