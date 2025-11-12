<script setup>
import { router } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    login_id: null,
    password: null,
});

const submit = () => {
    form.post(route('login'), {
        onError: () => {
            form.reset('password');
        },
    });
};

const navigateToRegister = () => {
    router.visit(route('register'));
};
</script>

<template>
    <div>
        <Head title="- Login" />

        <form @submit.prevent="submit"
            class="auth-form">
            <h2 class="form-title">
                Welcome Back
            </h2>

            <div class="form-group mb-6">
                <label for="login-id">
                    Username or Email
                </label>
                <input type="text" id="login-id" required :class="form.errors.login_id?'error':''"
                    :placeholder="form.errors.login_id?form.errors.login_id:'Enter your username or email'" v-model="form.login_id"/>
            </div>

            <div class="form-group mb-8">
                <label for="login-password">
                    Password
                </label>
                <input type="password" id="login-password" required 
                    placeholder="Your password" v-model="form.password"/>
            </div>

            <button type="submit" class="submit-button">
                Log In
            </button>

            <!-- I could add a remember me button since laravel has that functionality implemented -->

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <button @click.prevent="navigateToRegister"
                        class="ml-1 font-semibold text-indigo-600 hover:text-indigo-800 focus:outline-none focus:underline">
                        Register here
                    </button>
                </p>
            </div>
        </form>
    </div>
</template>
