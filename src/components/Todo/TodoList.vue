<script setup>
import { ref, onMounted } from 'vue';
import api from '../../services/api';
import { toast } from 'vue3-toastify';
import { useRoute } from 'vue-router';
import 'primeicons/primeicons.css'
import SingleItem from './SingleItem.vue';
import AddItem from './AddItem.vue';

const todoItems = ref([]);
const newTask = ref('');
const router = useRoute();

onMounted(async () => {
    try {
        const response = await api.get('tasks');
        todoItems.value = response.data.tasks;
    } catch (error) {
        console.error('Failed to fetch todos:', error);
    }
});

</script>

<template>
    <div class="h-100 w-full flex items-center justify-center bg-teal-lightest font-sans">
        <div class="container mx-auto my-10">
            <h1 class="text-center text-3xl font-semibold mb-4">To Do List</h1>
            <div class="md:w-1/2 mx-auto">
                <div class="bg-white shadow-md rounded-lg p-6">
                    <AddItem />
                    <ul id="todo-list">
                        <li v-for="(todo, index) in todoItems" :key="index">
                            <SingleItem :todo="todo"/>
                        </li>
                    </ul>

                    <div
                        v-if="showModal"
                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                    >
                        <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg">
                            <h2 class="text-lg font-semibold mb-4">Edit Todo</h2>
                            <input
                                type="text"
                                v-model="editTitle"
                                class="w-full px-4 py-2 border border-gray-300 rounded mb-4 focus:outline-none focus:border-blue-500"
                            />
                            <div class="flex justify-end">
                                <button
                                    class="bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2 hover:bg-gray-400"
                                    @click="showModal = false"
                                >
                                    Cancel
                                </button>
                                <button
                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                                    @click="submitEdit"
                                >
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
