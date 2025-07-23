<script setup lang="ts">
import type { Price } from "@/types/price";
import InputComponent from "./InputComponent.vue";

defineProps<{
  price: Price;
}>();

const emit = defineEmits(["resetPrice"]);
const handleResetPrice = () => {
  emit("resetPrice");
};
</script>
<template>
  <div class="w-full border border-blue-500 rounded-lg overflow-hidden">
    <div
      class="text-xl p-4 bg-[rgb(8,12,32)] flex flex-row w-full justify-between items-center"
    >
      <p>Set Price</p>
      <button
        @click="handleResetPrice"
        class="text-sm bg-blue-500 py-1.5 px-3 rounded-lg cursor-pointer"
      >
        Reset
      </button>
    </div>
    <div class="w-full p-4 flex flex-col justify-center bg-[rgb(33,32,47)]">
      <!-- Base Price -->
      <InputComponent
        label=" Base Price "
        type="number"
        v-model="price.based_price"
        placeholder="Base Price ( $ ) ..."
      />
      <!-- Discounted Price -->
      <InputComponent
        label=" Discounted Price "
        type="number"
        v-model="price.discounted_price"
        placeholder="Discounted Price ( $ ) ..."
      />
      <!-- Discount Start Date Input -->
      <InputComponent
        label="Discount Starts At"
        type="datetime-local"
        v-model="price.discount_start_date"
        placeholder="Select start date & time"
      />
      <!-- Discount End Date -->
      <InputComponent
        label="Discount Ends At"
        type="datetime-local"
        v-model="price.discount_end_date"
        placeholder="Select end date & time"
      />
    </div>
  </div>
</template>
<style scoped></style>
