<script setup>
import Header from './components/Header.vue';
</script>

<template>
    <div class="min-h-screen flex flex-col bg-gray-800">
        <Header />

        <!-- Main content area -->
        <main class="flex-grow">
            <router-view />
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white p-4 text-center fixed bottom-0 left-0 right-0">
            <p>&copy; 2025 My App. All rights reserved.</p>
        </footer>
    </div>
</template>

<style scoped></style>
