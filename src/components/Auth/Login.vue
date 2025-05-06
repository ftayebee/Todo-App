<template>
    <div class="min-h-3/4 flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Login to Your Account</h2>

            <form @submit.prevent="submitForm" class="space-y-5">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input
                        v-model="email"
                        type="email"
                        id="email"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input
                        v-model="password"
                        type="password"
                        id="password"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                <div class="flex items-center">
                    <input
                        v-model="remember"
                        type="checkbox"
                        id="remember"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                    />
                    <label for="remember" class="ml-2 block text-sm text-gray-900">Remember me</label>
                </div>

                <div>
                    <button
                        type="submit"
                        class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition"
                    >
                        Sign In
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../../store/authStore';
import { toast } from 'vue3-toastify';
import api from '../../services/api';

const email = ref('');
const password = ref('');
const remember = ref(false);

const error = ref('');
const router = useRouter();
const authStore = useAuthStore();

// Submit Form
async function submitForm() {
    error.value = '';

    try {
        const response = await api.post('login', {
            email: email.value,
            password: password.value,
        });

        const { token, user } = response.data;
        authStore.setAuthData(user, token);

        if (remember.value) {
            localStorage.setItem('user_token', token);
            localStorage.setItem('user_data', JSON.stringify(user));
        } else {
            sessionStorage.setItem('user_token', token);
            sessionStorage.setItem('user_data', JSON.stringify(user));
        }
        toast.success('Login successful!')
        router.push('/todos');
    } catch (error) {
        const errorMessage = error.response?.data?.message || 'Login failed. Please try again.';
        error.value = errorMessage;
        toast.error(errorMessage);
        console.log('Error response:', error.response);
    }
}
</script>
