<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const user = computed(() => page.props.auth.user)
</script>
<template>
    <div>
        <header>
            <div class="nav-container">
                <img :src="getImageUrl(FFDLP)" alt="FFDLP Logo" class="logo" />
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
                        <a href="https://github.com/Dranelmek/LaraVue-showcase"
                        class="nav-link" target="_blank">GitHub</a>
                    </div>
                    
                    <div v-if="user" class="space-x-6">
                        <Link :href="route('logout')" method="post" as="button"
                        class="nav-link">Logout</Link>
                    </div>
                    <div v-else class="space-x-6">
                        <Link :href="route('login')"
                        class="nav-link">Login</Link>
                    </div>
                </nav>
            </div>
        </header>

        <main>
            <slot />
        </main>
        <footer>
            <div class="footer-container text-center py-4 text-sm text-gray-600">
                <p>FFDLP — LaraVue showcase</p>
                <p>Built by Kem Ibodi • <a href="https://github.com/Dranelmek/LaraVue-showcase" target="_blank" rel="noopener noreferrer" class="underline">Project on GitHub</a></p>
            </div>
        </footer>
    </div>
</template>

<script>
export default {
    props: ['FFDLP'],
    methods: {
        getImageUrl() {
            return '/images/logo.png';
            // ask Joel why this works and asset() doesn't
        }
    }
};
</script>
