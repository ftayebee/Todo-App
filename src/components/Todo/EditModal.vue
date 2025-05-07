<script setup>
import { ref, watch } from 'vue';
import { toast } from 'vue3-toastify';
import api from '../../services/api';

const props = defineProps({
    showModal: Boolean,
    todo: {
        type: Object,
        required: true
    }
});

const emit = defineEmits(['closeModal', 'taskUpdated']);

const editTask = ref({
    title: '',
    description: '',
    is_completed: false
});

const error = ref('');

// Watch for prop change to sync editTask
watch(() => props.todo, (newVal) => {
    if (newVal) {
        editTask.value = { ...newVal }; // shallow copy
    }
}, { immediate: true });

function validateForm() {
    return editTask.value.title && editTask.value.description;
}

async function submitTask() {
    error.value = '';

    if (!validateForm()) {
        toast.error('Title and Description are required.');
        return;
    }

    try {
        const id = props.todo.id;
        await api.post(`tasks/update/${id}`, {
            title: editTask.value.title,
            description: editTask.value.description,
            is_completed: editTask.value.is_completed,
        });

        toast.success('Task updated successfully!');
        emit('taskUpdated');
        emit('closeModal');
    } catch (error) {
        const errorMessage = error.response?.data?.message || 'Task update failed. Please try again.';
        error.value = errorMessage;
        toast.error(errorMessage);
        console.log('Error response:', error);
    }
}
</script>

<template>
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg">
            <h2 class="text-lg font-semibold mb-4">Edit Todo</h2>
            <input
                type="text"
                v-model="editTask.title"
                class="w-full px-4 py-2 border border-gray-300 rounded mb-4 focus:outline-none focus:border-blue-500"
                placeholder="Title"
            />
            <textarea
                v-model="editTask.description"
                placeholder="Description"
                class="w-full mb-3 p-2 border border-gray-300 rounded"
            ></textarea>
            <div class="flex justify-end">
                <button
                    class="bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2 hover:bg-gray-400"
                    @click="$emit('closeModal')"
                >
                    Cancel
                </button>
                <button
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                    @click="submitTask"
                >
                    Save
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
