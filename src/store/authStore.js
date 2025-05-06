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
  },
})
