<script setup>
import api from '../../services/api';
import { toast } from 'vue3-toastify';
import 'primeicons/primeicons.css'

async function addTask() {
    if (!newTask.value.trim()) {
        toast.error('Task cannot be empty.');
        return;
    }

    try {
        const response = await api.post('tasks/store', {
            title: newTask.value,
            is_completed: false,
        });
        todoItems.value.unshift(response.data.tasks);

        toast.success('Task added successfully!');
        newTask.value = '';
    } catch (error) {
        console.error('Error adding task:', error);
        toast.error('Failed to add task.');
    }
}

</script>

<template>
    <form id="todo-form">
        <div class="flex mb-4">
            <input
                v-model="newTask"
                type="text"
                class="w-full px-4 py-2 mr-2 rounded-lg shadow border border-gray-300 focus:outline-none focus:border-blue-500"
                placeholder="Add new task"
                required
            />
            <button
                @click="addTask"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            >
                Add
            </button>
        </div>
    </form>
</template>

<style scoped>
</style>
