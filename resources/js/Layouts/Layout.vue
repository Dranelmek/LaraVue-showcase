<script setup>
</script>

<template>
    <div>
        <header>
            <nav>
                <div class="space-x-6">
                    <Link :href="route('home')"
                    class="nav-link">Home</Link>
                    
                </div>
                <div class="space-x-6">
                    <Link :href="route('about')"
                    class="nav-link">About</Link>
                </div>
                <div class="space-x-6">
                    <Link :href="route('login')"
                    class="nav-link">Login</Link>
                </div>
            </nav>
        </header>

        <main>
            <slot />
        </main>
    </div>
</template>

<style>
.navLinks a {
    font-weight: 600;
    text-decoration: none;
}

.navLinks a:hover {
    color: rgb(193, 243, 243);
}
</style>