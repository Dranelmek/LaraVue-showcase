<template>
    <div>
        <Head title="- Register" />
        
        <form class="auth-form">
            <h2 class="text-3xl font-extrabold text-slate-200 mb-8 text-center">
                Register a new account
            </h2>
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