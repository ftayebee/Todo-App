<script setup>
import { ref, onMounted } from 'vue';
import api from '../../services/api';
import { useRouter } from 'vue-router';
import 'primeicons/primeicons.css';
import SingleItem from './SingleItem.vue';
import { useAuthStore } from '../../store/authStore';
import Alert from '../Alert.vue';
import AddModal from './AddModal.vue';

const todoItems = ref([]);
const router = useRouter();
const authStore = useAuthStore();

const isAddModalOpen = ref(false);

const toggleAddModal = () => {
  isAddModalOpen.value = !isAddModalOpen.value;
};

async function fetchTasks() {
    try {
        const response = await api.get('tasks');
        todoItems.value = response.data.tasks;
    } catch (error) {
        console.error('Failed to fetch todos:', error);
    }
}

onMounted(async () => {
    if (!authStore.isAuthenticated) {
        router.push('/login');
        return;
    }

    fetchTasks();
});
</script>

<template>
    <div class="h-100 w-full flex items-center justify-center bg-teal-lightest font-sans">
        <div class="container mx-auto my-10">
            <div class="md:w-1/2 mx-auto flex justify-between items-center mt-20 mb-8">
                <h1 class="text-3xl font-semibold text-white">ToDo List</h1>
                <button
                    @click="toggleAddModal"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                >
                    <i class="pi pi-plus text-sm"></i> Add New
                </button>

                <AddModal :isAddModalOpen="isAddModalOpen" @closeModal="isAddModalOpen = false" @taskAdded="fetchTasks"/>
            </div>

            <div class="md:w-1/2 mx-auto">
                <div class="bg-gray-800 shadow-md">
                    <Alert :isValid="todoItems && todoItems.length === 0"/>

                    <ul id="todo-list">
                        <li v-for="(todo, index) in todoItems" :key="index">
                            <SingleItem :todo="todo" @refreshTasks="fetchTasks"/>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
