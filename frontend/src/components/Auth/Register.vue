<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-800">
        <div class="w-full max-w-md bg-gray rounded-2xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-100 text-center mb-6">Sign Up</h2>

            <form @submit.prevent="submitForm" class="space-y-5">
                <div class="mt-3">
                    <label for="email" class="block text-sm font-medium text-gray-200 mb-1">Full Name</label>
                    <input
                        v-model="name"
                        type="text"
                        id="name"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-900 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                    <p v-if="validationErrors.name" class="text-red-500 text-sm my-1">{{ validationErrors.name }}</p>
                </div>
                <div class="mt-3">
                    <label for="email" class="block text-sm font-medium text-gray-200 mb-1">Email Address</label>
                    <input
                        v-model="email"
                        type="email"
                        id="email"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-900 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                    <p v-if="validationErrors.email" class="text-red-500 text-sm my-1">{{ validationErrors.email }}</p>
                </div>

                <div class="mt-3">
                    <label for="password" class="block text-sm font-medium text-gray-200 mb-1">Password</label>
                    <input
                        v-model="password"
                        type="password"
                        id="password"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-900 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                    <p v-if="validationErrors.password" class="text-red-500 text-sm my-1">{{ validationErrors.password }}</p>
                </div>

                <div class="mt-3">
                    <button
                        type="submit"
                        class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition"
                    >
                        Sign Up
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
const name = ref('');
const password = ref('');
const remember = ref(false);

const error = ref('');
const router = useRouter();
const authStore = useAuthStore();

// Validation errors
const validationErrors = ref({
    email: '',
    name: '',
    password: ''
});

function validateForm() {
    let isValid = true;
    validationErrors.value = { email: '', name: '', password: '' };

    if (!email.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
        validationErrors.value.email = 'Please enter a valid email address.';
        isValid = false;
    }

    if (name.value.length < 4) {
        validationErrors.value.name = 'Name must be at least 4 characters long.';
        isValid = false;
    }

    if (password.value.length < 8) {
        validationErrors.value.password = 'Password must be at least 8 characters long.';
        isValid = false;
    }

    return isValid;
}

async function submitForm() {
    error.value = '';

    if (!validateForm()) {
        toast.error('Please fix the validation errors.');
        return;
    }

    try {
        const response = await api.post('register', {
            name: name.value,
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
        toast.success('Registration successful!');
        router.push('/todos');
    } catch (error) {
        const errorMessage = error.response?.data?.message || 'Registration failed. Please try again.';
        error.value = errorMessage;
        toast.error(errorMessage);
        console.log('Error response:', error.response);
    }
}
</script>