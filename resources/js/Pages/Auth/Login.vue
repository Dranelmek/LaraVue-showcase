<template>
    <div>
        <Head title="- Login" />

        <form
            class="auth-form">
            <h2 class="text-3xl font-extrabold text-slate-200 mb-8 text-center">
                Welcome Back
            </h2>

            <!-- Username/Email Input -->
            <div class="form-group mb-6">
                <label for="login-id">
                    Username or Email
                </label>
                <input type="text" id="login-id" required
                    placeholder="Enter your username or email" />
            </div>

            <!-- Password Input -->
            <div class="form-group mb-8">
                <label for="login-password">
                    Password
                </label>
                <input type="password" id="login-password" required
                    placeholder="Your password" />
            </div>

            <!-- Login Button (Submit) - Same style as Register button -->
            <button type="submit" class="submit-button">
                Log In
            </button>

            <!-- Register Link/Button -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <!-- This is a decorative button/link styled to look like a call-to-action -->
                    <button @click.prevent="navigateToRegister"
                        class="ml-1 font-semibold text-indigo-600 hover:text-indigo-800 focus:outline-none focus:underline">
                        Register here
                    </button>
                </p>
            </div>
        </form>
    </div>
</template>

<script setup>
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';

const loginData = reactive({
    identifier: '',
    password: ''
});

const loginUser = () => {
    pass; // Implement login logic here
};

const navigateToRegister = () => {
    router.visit(route('register'));
};
</script>