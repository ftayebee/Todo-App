// src/services/api.js
import axios from 'axios'

const api = axios.create({
  baseURL: 'https://todo-app.fahimtayebee.com/api/',
  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json',
  },
})

// Automatically attach token if available
api.interceptors.request.use((config) => {
  const token = localStorage.getItem('user_token') || sessionStorage.getItem('user_token')
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }
  return config
}, (error) => {
  return Promise.reject(error)
})

export default api
