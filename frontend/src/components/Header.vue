<script setup>
import { useRouter } from 'vue-router'
import { useAuthStore } from '../store/authStore'
import { toast } from 'vue3-toastify'
import api from '../services/api';

const router = useRouter();
const authStore = useAuthStore();

async function logout() {
  try {
    await api.post('logout');
  } catch (error) {
    console.error('Logout API error:', error);
    toast.error('Logout failed on server.');
  }

  authStore.logout();

  localStorage.removeItem('user_token');
  localStorage.removeItem('user_data');
  sessionStorage.removeItem('user_token');
  sessionStorage.removeItem('user_data');

  toast.success('Logged out successfully');
  router.push('/login');
}
</script>


<template>
    <header class="bg-gray-900 text-white p-4 fixed top-0 left-0 right-0 z-10">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold flex items-center italic">
                <img
                    src="https://fahimtayebee.com/wp-content/uploads/2024/08/FINAL-LOGO-FTAYEBEE-LIGHT-300x134.png.webp"
                    alt=""
                    class="col-span-2 max-h-12 w-full object-contain lg:col-span-1"
                />
                Todo
            </h1>
            <nav>
                <ul class="flex space-x-4">
                    <li v-if="!authStore.isAuthenticated">
                        <router-link to="/login" class="text-lg hover:underline">Login</router-link>
                    </li>
                    <li v-if="!authStore.isAuthenticated">
                        <router-link to="/register" class="text-lg hover:underline">Register</router-link>
                    </li>
                    <li v-if="authStore.isAuthenticated">
                        <router-link to="/todos" class="text-lg hover:underline">Todo List</router-link>
                    </li>
                    <li v-if="authStore.isAuthenticated">
                        <button @click="logout" class="text-lg hover:underline">Logout</button>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
</template>

<style scoped></style>
