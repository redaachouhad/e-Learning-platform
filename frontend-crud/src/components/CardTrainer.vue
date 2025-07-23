<script setup lang="ts">
import { useTrainerStore } from "@/stores/trainerStore";
import type { User } from "@/types/user";
import IconFollower from "./icons/IconFollower.vue";
import IconFollowing from "./icons/IconFollowing.vue";
import IconFollowUser from "./icons/IconFollowUser.vue";
import IconUnfollowUser from "./icons/IconUnfollowUser.vue";

const props = defineProps<{
  trainer: User | undefined;
  followed: boolean | undefined;
  followers_count: number | undefined;
  followings_count: number | undefined;
}>();

const trainerStore = useTrainerStore();
const handleShowFollow = () => {
  trainerStore.toggleFollowTrainer(props.trainer?.id as number);
};
</script>
<template>
  <div
    class="sticky top-20 bg-[rgb(21,11,33)] p-4 flex flex-col md:flex-row lg:flex-col justify-between items-center text-white gap-2 rounded-lg border-2 border-blue-500"
  >
    <img src="/images/trainer-image.png" alt="" srcset="" class="w-80" />
    <div class="flex flex-col gap-2 flex-1 justify-center items-center">
      <p class="text-center text-2xl font-semibold">{{ trainer?.name }}</p>
      <p class="text-lg text-center font-medium">Artist | Comic Writer</p>
      <p class="text-sm text-center">National Comics Publications, NY, USA</p>
      <button
        v-if="!followed"
        @click="handleShowFollow"
        type="button"
        class="flex flex-row items-center justify-center gap-2 mt-3 cursor-pointer text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
      >
        <IconFollowUser />
        <p>Follow</p>
      </button>
      <button
        v-else
        @click="handleShowFollow"
        type="button"
        class="flex flex-row items-center justify-center gap-2 mt-3 cursor-pointer focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
      >
        <IconUnfollowUser />
        <p>Unfollow</p>
      </button>

      <div class="flex flex-row w-full">
        <div class="flex-1 flex flex-col justify-center items-center">
          <IconFollowing />
          <p class="text-xl">{{ followings_count }}</p>
          <p class="text-sm">Following</p>
        </div>
        <div class="border-l border-gray-200"></div>

        <div class="flex-1 flex flex-col justify-center items-center">
          <IconFollower />
          <p class="text-xl">{{ followers_count }}</p>
          <p class="text-sm">Followers</p>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped></style>
