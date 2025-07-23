<script setup lang="ts">
import { ref } from "vue";

const props = defineProps<{
  listOfItems: string[];
  label: string;
}>();

const newItem = ref("");

const indexToEdit = ref(0);

const editButton = ref(false);

// dynamic emit
const emit = defineEmits<{
  (event: `${string}:${string}`, payload?: any): void;
}>();

// Dynamic event emit helper
const emitWithLabel = (action: string, payload?: any) => {
  emit(`${action}:${props.label.toLowerCase()}`, payload);
};
// handle Add or Update Item
const handleAddOrUpdateItem = () => {
  if (editButton.value) {
    // updating Item
    updateItem();
  } else {
    // add Item
    addItem();
  }
  newItem.value = "";
};

// adding Item
const addItem = () => {
  if (newItem.value.trim()) {
    emitWithLabel("add", newItem.value.trim());
  }
};

// Update Item
const updateItem = () => {
  emitWithLabel("update", {
    index: indexToEdit.value,
    updatedItem: newItem.value,
  });
  editButton.value = false;
};

// deleting Item
const deleteItem = (index: number) => {
  emitWithLabel("delete", index);
};

// edit Item
const editItem = (index: number, item: string) => {
  editButton.value = true;
  newItem.value = item.trim();
  indexToEdit.value = index;
};

// reset listOfItems
const resetItem = () => {
  emitWithLabel("reset");
};
</script>
<template>
  <div class="border border-blue-500 rounded-lg overflow-hidden text-white">
    <div
      class="text-xl p-4 bg-[rgb(8,12,32)] flex flex-row w-full justify-between items-center"
    >
      <p>{{ label }}</p>
      <button
        @click="resetItem"
        class="text-sm bg-blue-500 py-1.5 px-3 rounded-lg cursor-pointer"
      >
        Reset
      </button>
    </div>
    <div class="p-4 bg-[rgb(33,32,47)] text-sm">
      <!-- Create new item -->
      <div
        class="border border-gray-600 my-4 flex flex-row justify-between rounded-lg overflow-hidden"
      >
        <input
          type="text"
          class="w-full p-2 outline-none"
          :placeholder="`Add ${label} here ...`"
          v-model="newItem"
        />
        <button
          @click="handleAddOrUpdateItem"
          class="bg-blue-500 text-white p-3 cursor-pointer"
        >
          <span class="whitespace-nowrap">
            {{ editButton ? "Save Changes" : "Add" }}</span
          >
        </button>
      </div>

      <!-- table of items -->
      <div
        v-show="listOfItems.length > 0"
        class="relative overflow-x-auto shadow-md sm:rounded-lg"
      >
        <table
          class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
          <thead
            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
          >
            <tr>
              <th scope="col" class="px-6 py-3 w-full">{{ label }}</th>
              <th scope="col" class="px-6 py-3">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(item, index) in listOfItems"
              :key="index"
              class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
            >
              <td
                scope="row"
                class="p-3 font-medium text-gray-900 whitespace-nowrap dark:text-white"
              >
                <p class="w-full whitespace-normal">
                  {{ item }}
                </p>
              </td>

              <td class="px-6 py-4 flex flex-row items-center gap-6">
                <button
                  @click="editItem(index, item)"
                  class="font-medium text-green-600 dark:text-green-500 hover:underline cursor-pointer"
                >
                  Edit
                </button>
                <button
                  @click="deleteItem(index)"
                  class="font-medium text-red-600 dark:text-red-500 hover:underline cursor-pointer"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
