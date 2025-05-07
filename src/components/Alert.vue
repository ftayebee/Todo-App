<script setup>
defineProps({
  isValid: Boolean,
});
</script>

<template>
  <div
    v-if="isValid"
    class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-md shadow-sm "
    role="alert"
  >
    <p class="font-bold">Oops!</p>
    <p>You don't have any tasks yet.</p>
  </div>
</template>

<style scoped></style>
