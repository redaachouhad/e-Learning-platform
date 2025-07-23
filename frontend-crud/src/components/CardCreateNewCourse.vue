<script setup lang="ts">
defineProps<{
  mode: "createCourse" | "editCourse";
}>();
</script>
<template>
  <div
    class="bg-[#121e2d] text-white p-4 border border-blue-500 rounded-lg flex flex-col gap-2"
    style="
      background-image: url('/images/corner-4.png');
      background-position: right;
      background-size: contain;
      background-repeat: no-repeat;
    "
  >
    <p class="text-3xl" v-if="mode === 'createCourse'">Create A New Course</p>
    <p class="text-3xl" v-if="mode === 'editCourse'">Edit Course</p>
    <p class="text-md">
      Enlighten the world with your knowledge. Use our Course Creator to design
      a well-structured course; set whatever price you feel worthy of, and
      publish at our platform. or,Want to edit your existing course? Jump to
      <RouterLink
        to="/"
        class="text-blue-500 cursor-pointer hover:underline hover:underline-blue-500"
        >Courses Section</RouterLink
      >
    </p>
  </div>
</template>
