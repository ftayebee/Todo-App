<script setup>
import { ref } from 'vue';
import api from '../../services/api';
import { toast } from 'vue3-toastify';
import { useRouter } from 'vue-router';
import EditModal from './EditModal.vue';

const props = defineProps({
    todo: {
        type: Object,
        required: true,
    },
});
const emit = defineEmits(['refreshTasks']);
const router = useRouter();

const showModal = ref(false);
const editingTodo = ref(null);

function toggleEditModal(todo) {
    editingTodo.value = { ...todo };
    showModal.value = true;
}

async function markDone(id) {
    try {
        await api.post(`/tasks/update/${id}`, {
            is_completed: true,
        });
        toast.success('Task marked as completed!');
        emit('refreshTasks');
    } catch (error) {
        toast.error('Failed to update task.');
        console.error(error);
    }
}

async function deleteTodo(id) {
    try {
        await api.post(`/tasks/destroy/${id}`);
        toast.success('Task deleted successfully!');
        emit('refreshTasks');
    } catch (error) {
        toast.error('Failed to delete task.');
        console.error(error);
        router.push('/todos');
    }
}
</script>

<template>
    <div class="border border-gray-700 rounded-lg p-4 mb-4 bg-gray-700 shadow-sm flex justify-between items-center">
        <div class="w-full mb-0">
            <p class="text-lg font-semibold text-gray-100" :class="{ 'line-through text-gray-400': todo.is_completed }">
                {{ todo.title }}
            </p>
            <p class="text-md text-gray-200" :class="{ 'line-through text-gray-400': todo.is_completed }">
                {{ todo.description }}
            </p>
        </div>

        <div class="flex justify-end space-x-2">
            <button
                v-if="!todo.is_completed"
                class="p-2 text-green-600 border border-green-600 rounded hover:text-white hover:bg-green-600"
                @click="markDone(todo.id)"
                title="Mark as Complete"
            >
                <i class="pi pi-check-circle"></i>
            </button>
            <button
                v-if="!todo.is_completed"
                class="p-2 text-blue-600 border border-blue-600 rounded hover:text-white hover:bg-blue-600"
                @click="toggleEditModal(todo)"
                title="Edit Task"
            >
                <i class="pi pi-pen-to-square"></i>
            </button>
            <button
                class="p-2 text-red-600 border border-red-600 rounded hover:text-white hover:bg-red-600"
                @click="deleteTodo(todo.id)"
                title="Remove Task"
            >
                <i class="pi pi-trash"></i>
            </button>
        </div>
    </div>

    <EditModal
        :showModal="showModal"
        :todo="todo"
        @closeModal="showModal = false"
        @taskUpdated="$emit('refreshTasks')"
    />
</template>

<style scoped></style>
