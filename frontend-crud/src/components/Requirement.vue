<script setup lang="ts">
defineProps<{ requirements: string[] | undefined }>();
</script>
<template>
  <div class="border border-blue-400 rounded-lg overflow-hidden flex flex-col">
    <div class="flex justify-start items-center p-2 bg-[#090918]">
      <p class="font-semibold p-3">Requirements</p>
    </div>
    <div class="flex flex-row w-full relative">
      <div class="image-bg-1 absolute top-0 left-0 w-full h-full"></div>
      <div class="flex-1 text-sm p-6 text-gray-300">
        <ul class="list-disc list-inside flex flex-col gap-2">
          <li v-for="(item, index) in requirements" :key="index">
            {{ item }}
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
<style scoped>
.image-bg-1 {
  background-image: url("/images/corner-7.png");
  background-size: contain;
  background-position: right;
  background-repeat: no-repeat;
}
</style>
