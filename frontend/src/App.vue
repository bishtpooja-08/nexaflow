<script setup lang="ts">
import { ref } from 'vue'
import api from './services/api'

const email = ref('')
const password = ref('')
const errorMessage = ref('')
const isLoading = ref(false)

const login = async () => {
  errorMessage.value = ''
  isLoading.value = true

  try {
    const response = await api.post('/login', {
      email: email.value,
      password: password.value,
    })

    console.log('Login response:', response.data)
  } catch (error: any) {
    errorMessage.value =
      error.response?.data?.message ?? 'Login failed. Please try again.'
  } finally {
    isLoading.value = false
  }
}
</script>

<template>
  <main class="login-page">
    <section class="login-card">
      <header class="login-header">
        <h1>NexaFlow</h1>
        <p>Sales Operations Platform</p>
      </header>


        <form class="login-form" @submit.prevent="login">
            <div class="form-group">
            <label for="email">Email</label>

            <input
                id="email"
                v-model="email"
                type="email"
                placeholder="Enter your email"
                autocomplete="email"
                required
            />
            </div>

            <div class="form-group">
            <label for="password">Password</label>

            <input
                id="password"
                v-model="password"
                type="password"
                placeholder="Enter your password"
                autocomplete="current-password"
                required
            />
            </div>

            <p v-if="errorMessage" class="error-message">
            {{ errorMessage }}
            </p>

            <button
            class="login-button"
            type="submit"
            :disabled="isLoading"
            >
            {{ isLoading ? 'Logging in...' : 'Login' }}
            </button>
        </form>
    </section>
  </main>
</template>

<style scoped>
.login-page {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 24px;
  box-sizing: border-box;
  background: #f3f4f6;
}

.login-card {
  width: 100%;
  max-width: 420px;
  padding: 40px;
  box-sizing: border-box;
  background: #ffffff;
  border: 1px solid #e5e7eb;
  border-radius: 16px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
}

.login-header {
  margin-bottom: 32px;
  text-align: center;
}

.login-header h1 {
  margin: 0;
  font-size: 32px;
  font-weight: 700;
  color: #111827;
}

.login-header p {
  margin: 8px 0 0;
  font-size: 14px;
  color: #6b7280;
}

.login-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-group label {
  font-size: 14px;
  font-weight: 600;
  color: #374151;
}

.form-group input {
  width: 100%;
  padding: 12px 14px;
  box-sizing: border-box;
  border: 1px solid #d1d5db;
  border-radius: 8px;
  outline: none;
  font-size: 15px;
  transition: border-color 0.2s;
}

.form-group input:focus {
  border-color: #4f46e5;
}

.login-button {
  width: 100%;
  padding: 13px;
  border: none;
  border-radius: 8px;
  background: #4f46e5;
  color: #ffffff;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.2s;
}

.login-button:hover:not(:disabled) {
  background: #4338ca;
}

.login-button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.error-message {
  margin: -4px 0 0;
  color: #dc2626;
  font-size: 14px;
}
</style>
