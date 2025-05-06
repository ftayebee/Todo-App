<script setup>
import { ref, onMounted } from 'vue';
import api from '../../services/api';
import { toast } from 'vue3-toastify';
import { useRoute } from 'vue-router';
import 'primeicons/primeicons.css'

const router = useRoute();

async function markDone(id) {
    try {
        await api.post(`/tasks/update/${id}`, {
            is_completed: true,
        });
        toast.success('Task marked as completed!');
        router.push('/todos')
    } catch (error) {
        toast.error('Failed to update task.');
        console.error(error);
    }
}

async function deleteTodo(id) {
    try {
        await api.post(`/tasks/destroy/${id}`);
        toast.success('Task deleted successfully!');
        router.push('/todos')
    } catch (error) {
        toast.error('Failed to delete task.');
        console.error(error);
        router.push('/todos')
    }
}


const showModal = ref(false)
const editTitle = ref('')
const editingTodo = ref(null)

function openEditModal(todo) {
  editingTodo.value = todo
  editTitle.value = todo.title
  showModal.value = true
}

async function submitEdit() {
  try {
    const id = editingTodo.value.id
    const response = await axios.put(`/tasks/update/${id}`, {
      title: editTitle.value,
    })

    editingTodo.value.title = editTitle.value
    showModal.value = false
  } catch (err) {
    console.error('Edit failed:', err)
  }
}

</script>

<template>
    <div class="flex mb-4 items-center">
        <p
            class="w-full text-grey-darkest"
            :class="{ 'line-through text-gray-400': todo.is_completed }"
        >
            {{ todo.title }}
        </p>
        <button
            v-if="!todo.is_completed"
            class="p-1 ml-2 border-2 rounded text-green-600 border-green-600 hover:text-white hover:bg-green-600"
            @click="markDone(todo.id)"
            title="Mark as Complete"
        >
            <i class="pi pi-check-circle"></i>
        </button>
        <button
            class="p-1 ml-2 border-2 rounded text-blue-600 border-blue-600 hover:text-white hover:bg-blue-600"
            @click="openEditModal(todo)"
            title="Edit Task"
        >
            <i class="pi pi-pen-to-square"></i>
        </button>
        <button
            class="p-1 ml-2 border-2 rounded text-red-600 border-red-600 hover:text-white hover:bg-red-600"
            @click="deleteTodo(todo.id)"
            title="Remove Task"
        >
            <i class="pi pi-trash"></i>
        </button>
    </div>
</template>

<style scoped>
</style>
