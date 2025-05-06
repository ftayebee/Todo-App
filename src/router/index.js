import { createRouter, createWebHistory } from 'vue-router'
import Login from '../components/Auth/Login.vue'
import Register from '../components/Auth/Register.vue'
import TodoList from '../components/Todo/TodoList.vue'

const routes = [
  { path: '/', redirect: '/login' },
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/todos', component: TodoList }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
