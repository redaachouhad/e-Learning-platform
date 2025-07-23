<script setup lang="ts">
import { onMounted, ref } from "vue";
import IconUpload from "./icons/IconUpload.vue";

const props = defineProps<{ image: File | null | string }>();

const emit = defineEmits<{
  (e: "update:image", file: File): void;
  (e: "reset:image"): void;
}>();
const previewUrl = ref<string | null>(null); // store image URL

// handling the on change of the image
const handleFileOnchange = (event: Event) => {
  const target = event.target as HTMLInputElement;
  if (target.files && target.files[0]) {
    const file = target.files[0];
    previewUrl.value = URL.createObjectURL(file);
    emit("update:image", target.files[0]);
  }
};

// reset image
const handleResetImage = () => {
  previewUrl.value = null;
  emit("reset:image");
};

onMounted(() => {
  if (props.image) {
    if (props.image instanceof File) {
      previewUrl.value = URL.createObjectURL(props.image as File);
    } else if (typeof props.image === "string") {
      previewUrl.value = props.image.startsWith("https")
        ? (props.image as string)
        : (("http://localhost:8000/storage/" + props.image) as string);
    } else {
      previewUrl.value = null;
    }
  }
});
</script>
<template>
  <div class="w-full border border-blue-500 rounded-lg overflow-hidden">
    <div
      class="text-lg p-3 bg-[rgb(14,16,31)] flex flex-row items-center justify-between"
    >
      <p>Cover Photo</p>
      <button
        @click="handleResetImage"
        class="text-sm bg-blue-500 py-1.5 px-3 rounded-lg cursor-pointer"
      >
        Reset
      </button>
    </div>
    <div class="w-full p-6 bg-[rgb(33,32,47)]">
      <div class="flex items-center justify-center w-full">
        <label
          for="dropzone-file"
          class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500"
        >
          <template v-if="previewUrl">
            <img
              :src="previewUrl"
              alt="Preview"
              class="w-full h-full rounded-lg"
            />
          </template>
          <div
            v-else
            class="flex flex-col items-center justify-center pt-5 pb-6"
          >
            <IconUpload />
            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
              <span class="font-semibold">Click to upload</span> or drag and
              drop
            </p>
            <p class="text-xs text-gray-500 dark:text-gray-400">
              SVG, PNG, JPG or GIF (MAX. 800x400px)
            </p>
          </div>
          <input
            id="dropzone-file"
            type="file"
            class="hidden"
            @change="handleFileOnchange"
          />
        </label>
      </div>
    </div>
  </div>
</template>
