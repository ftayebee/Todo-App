<script setup>
import Header from './components/Header.vue';
</script>

<template>
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <Header />

        <!-- Main content area -->
        <main class="flex-grow">
            <router-view />
        </main>

        <!-- Footer -->
        <footer class="bg-blue-600 text-white p-4 text-center">
            <p>&copy; 2025 My App. All rights reserved.</p>
        </footer>
    </div>
</template>

<style scoped></style>
