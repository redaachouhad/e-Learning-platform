<script setup lang="ts">
import IconAccount from "@/components/icons/IconAccount.vue";
import IconPassword from "@/components/icons/IconPassword.vue";
import ProfileUserIcon from "@/components/icons/ProfileUserIcon.vue";
import ProfileMenuItem from "@/components/ProfileMenuItem.vue";
import SettingsDeleteAccount from "@/components/SettingsDeleteAccount.vue";
import SettingsProfileUser from "@/components/SettingsProfileUser.vue";
import SettingsUpdatePassword from "@/components/SettingsUpdatePassword.vue";
import { useAuthStore } from "@/stores/authStore";
import { ref } from "vue";

const authStore = useAuthStore();
const formType = ref("Profile");

const changeFormType = (type: string) => {
  formType.value = type;
};
</script>
<template>
  <div class="w-full flex-1 flex justify-center items-center">
    <div
      class="bg-blue-100 dark:bg-gray-800 w-[120vmin] h-[45rem] rounded-lg flex flex-row py-3"
    >
      <div class="w-[25%] flex flex-col border-r border-gray-700">
        <!-- Image and Name of the user -->
        <div class="flex flex-col justify-center items-center gap-2 p-5">
          <img
            id="avatarButton"
            type="button"
            class="w-35 rounded-full cursor-pointer"
            src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
            alt="User dropdown"
          />
          <p class="text-black dark:text-white">{{ authStore.user?.name }}</p>
        </div>

        <!-- Profile Menu -->
        <div class="flex-1">
          <ProfileMenuItem
            :icon="ProfileUserIcon"
            name="Profile"
            :clickFn="changeFormType"
            :formType="formType"
          />
          <ProfileMenuItem
            :icon="IconPassword"
            name="Password"
            :clickFn="changeFormType"
            :formType="formType"
          />
          <!-- <ProfileMenuItem
            :icon="IconAccount"
            name="Authentication"
            :clickFn="changeFormType"
            :formType="formType"
          />
          <ProfileMenuItem
            :icon="IconAccount"
            name="Authorization"
            :clickFn="changeFormType"
            :formType="formType"
          /> -->
          <ProfileMenuItem
            :icon="IconAccount"
            name="Account"
            :clickFn="changeFormType"
            :formType="formType"
          />
        </div>
      </div>
      <div class="flex-1 flex justify-center">
        <!-- User Information -->

        <template v-if="formType == 'Profile'">
          <SettingsProfileUser />
        </template>
        <!-- Change Password -->

        <template v-if="formType === 'Password'">
          <SettingsUpdatePassword />
        </template>

        <!-- Delete Account -->
        <template v-if="formType == 'Account'">
          <SettingsDeleteAccount />
        </template>
      </div>
    </div>
  </div>
</template>
<style scoped></style>
