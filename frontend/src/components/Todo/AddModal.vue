<script setup>
import { ref, onMounted } from 'vue';
import { toast } from 'vue3-toastify';
import api from '../../services/api';
import { useRouter } from 'vue-router';

defineProps({
    isAddModalOpen: Boolean
})
const emit = defineEmits(['closeModal', 'taskAdded']);

const newTask = ref({
  title: '',
  description: '',
  is_completed: false
});

const router = useRouter();
const error = ref('');

function validateForm() {
  if (!newTask.value.title || !newTask.value.description) {
    return false;
  }
  return true;
}

async function submitTask() {
    error.value = '';

    if (!validateForm()) {
        toast.error('Title and Description are required.');
        return;
    }

    try {
        const response = await api.post('tasks/store', {
            title: newTask.value.title,
            description: newTask.value.description,
            is_completed: newTask.value.is_completed,
        });
        console.log(response)
        toast.success('Task created successfully!');
        emit('taskAdded'); 
        emit('closeModal');
    } catch (error) {
        const errorMessage = error.response?.data?.message || 'Task creation failed. Please try again.';
        error.value = errorMessage;
        toast.error(errorMessage);
        console.log('Error response:', error);
    }
}
</script>

<template>
    <div
        v-if="isAddModalOpen"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
        <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg relative">
        <h2 class="text-xl font-semibold mb-4">Add New Task</h2>
        
        <!-- Add your form here -->
        <form @submit.prevent="submitTask">
            <input
            v-model="newTask.title"
            type="text"
            placeholder="Task title"
            class="w-full mb-3 p-2 border border-gray-300 rounded"
            required
            />
            <textarea
            v-model="newTask.description"
            placeholder="Description"
            class="w-full mb-3 p-2 border border-gray-300 rounded"
            ></textarea>
            <div class="flex justify-end gap-2">
            <button
                type="button"
                @click="$emit('closeModal')"
                class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500"
            >
                Cancel
            </button>
            <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
            >
                Save
            </button>
            </div>
        </form>
        </div>
    </div>
</template>

<style scoped>
</style>
