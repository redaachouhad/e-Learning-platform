<script setup lang="ts">
import { useRouter } from "vue-router";

const router = useRouter();
const gotToHome = () => {
  router.push("/");
};
</script>
<template>
  <div class="w-full flex-1 flex justify-center items-center">
    <div
      class="w-[60vmin] flex flex-col justify-center items-center p-10 gap-4 bg-[rgb(22,24,47)] rounded-xl"
    >
      <p class="text-[#4c508bca] font-bold text-[10rem]">404</p>
      <p class="text-gray-400">The page you're looking for is not found.</p>
      <hr class="text-gray-400 w-full" />
      <p class="text-white text-sm text-center">
        Make sure the address is correct and that the page hasn't moved. If you
        think this is a mistake,contact us.
      </p>
      <button
        @click="gotToHome"
        class="bg-blue-500 hover:bg-blue-600 text-white p-1.5 rounded-lg cursor-pointer"
      >
        Take me home
      </button>
    </div>
  </div>
</template>
<style scoped></style>
