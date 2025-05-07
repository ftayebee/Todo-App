import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: null,
  }),
  getters: {
    isAuthenticated: (state) => !!state.token,  // Returns true if token exists
  },
  actions: {
    setAuthData(user, token) {
      this.user = user
      this.token = token
    },
    logout() {
      this.user = null
      this.token = null
    },
    initializeAuth() {
      const token = localStorage.getItem('user_token') || sessionStorage.getItem('user_token');
      const userData = localStorage.getItem('user_data') || sessionStorage.getItem('user_data');

      if (token && userData) {
        this.setAuthData(JSON.parse(userData), token);
      }
    },
  },
})
