import { createRouter, createWebHistory } from 'vue-router'
import Login from '../components/Auth/Login.vue'
import Register from '../components/Auth/Register.vue'
import TodoList from '../components/Todo/TodoList.vue'
import { useAuthStore } from '../store/authStore'

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

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();

  if (to.meta.requiresAuth && !authStore.token) {
    next('/login');
  } else {
    next();
  }
});

export default router
