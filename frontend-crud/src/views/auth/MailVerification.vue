<script setup lang="ts">
import axiosInstance from "@/axios";
import CardAuthLayout from "@/components/CardAuthLayout.vue";

const sendVerifyEmailNotification = async () => {
  try {
    await axiosInstance.get("/sanctum/csrf-cookie");
    const response = await axiosInstance.post(
      "api/email/verification-notification "
    );
    console.log("response: ");
    console.log(response);
  } catch (error) {
    console.log("error: ");
    console.log(error);
  }
};

// onMounted(() => {
//   sendVerifyEmailNotification();
// });
</script>
<template>
  <CardAuthLayout>
    <div class="flex flex-col items-center justify-center gap-8 p-10">
      <img src="/images/confirm-email.png" alt="" class="w-24" />
      <h1 class="text-3xl font-medium text-white">Please check your email!</h1>
      <p class="text-center text-gray-400">
        An email has been sent to xyz@abc.com. Please click on the included link
        to reset your password.
      </p>
      <div class="w-full flex flex-col">
        <p class="text-gray-300 text-sm">Didn't receive the email?</p>
        <div class="w-full flex flex-col justify-end items-end gap-2">
          <button
            @click="sendVerifyEmailNotification"
            class="text-white bg-blue-500 hover:bg-blue-600 cursor-pointer text-sm p-2 rounded-md"
          >
            Resend Verification Email
          </button>
        </div>
      </div>
    </div>
  </CardAuthLayout>
</template>
