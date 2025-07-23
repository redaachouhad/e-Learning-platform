<script setup lang="ts">
import { RouterLink, useRoute } from "vue-router";

const router = useRoute();
</script>
<template>
  <div class="flex-1 flex flex-col justify-center items-center">
    <div class="w-[100vmin] flex flex-row rounded-lg relative">
      <img
        src="/images/forgot-password-bg-shape.png"
        alt=""
        class="w-60 absolute -right-36 -top-28 hidden lg:block"
      />
      <img
        src="/images/forgot-password-shape-1.png"
        alt=""
        class="w-52 absolute -left-36 -bottom-24 hidden lg:block"
      />
      <div
        class="flex-1/3 bg-[linear-gradient(45deg,_#012552,_#001835)] relative rounded-l-lg z-10 p-5"
      >
        <img
          src="/images/forgot-password-half-circle.png"
          alt=""
          class="w-full h-[50%] absolute top-0 left-0"
        />
        <div
          class="w-full h-full top-0 left-0 flex flex-col p-2 items-center justify-center text-white gap-6"
        >
          <p class="text-3xl font-bold">e-Learning App</p>
          <br />
          <br />
          <p class="text-sm text-center">
            Empower your future with courses designed to inspire, educate, and
            elevate your skills.
          </p>
          <br /><br />

          <div
            v-if="router.path === '/login'"
            class="flex flex-col gap-2 items-center"
          >
            <p>Don't have an account?</p>
            <RouterLink
              to="/register"
              class="bg-blue-500 p-2 rounded-lg text-sm"
              >Get Started ?</RouterLink
            >
          </div>

          <div
            v-if="router.path === '/register'"
            class="flex flex-col gap-2 items-center"
          >
            <p>Have an account?</p>
            <RouterLink to="/login" class="bg-blue-500 p-2 rounded-lg text-sm"
              >Login</RouterLink
            >
          </div>
        </div>
      </div>
      <div
        class="flex-2/3 bg-[#1b1c27] flex justify-center items-center rounded-r-lg z-10"
      >
        <slot></slot>
      </div>
    </div>
  </div>
</template>
