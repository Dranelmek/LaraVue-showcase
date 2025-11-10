<template>
    <div>
        <Head title="- Register" />
        
        <h1 class="form-title">
            <h2>Register a new account</h2>
        </h1>
        <form @submit.prevent="registerUser" class="registration-form">
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" required
                    placeholder="Enter your email" />
            </div>

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" required
                    placeholder="Choose a username" />
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" required
                    placeholder="Create a password" />
            </div>

            <div class="form-group">
                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" required
                    placeholder="Re-enter your password" />
            </div>

            <button type="submit" class="submit-button">Register</button>
        </form>
    </div>
</template>