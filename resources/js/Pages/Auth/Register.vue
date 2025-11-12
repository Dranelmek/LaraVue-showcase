<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: null,
    name: null,
    password: null,
    password_confirmation: null,
});

const submit = () => {
    form.post(route('register'), {
        onError: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>
<template>
    <div>
        <Head title="- Register" />
        
        <form @submit.prevent="submit" class="auth-form">
            <h2 class="form-title">
                Register a new account
            </h2>
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" required
                    placeholder="Enter your email" v-model="form.email"/>
            </div>

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" required
                    placeholder="Choose a username" v-model="form.name"/>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" required :class="form.errors.password?'error':''"
                    :placeholder="form.errors.password?'Passwords don\'t match!':'Create a password'" v-model="form.password"/>
            </div>

            <div class="form-group">
                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" required :class="form.errors.password?'error':''"
                    :placeholder="form.errors.password?'Passwords don\'t match!':'Create a password'" v-model="form.password_confirmation"/>
            </div>

            <button type="submit" class="submit-button" :disabled="form.processing">Register</button>
        </form>
    </div>
</template>