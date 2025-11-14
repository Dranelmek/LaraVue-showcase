<script setup>
    import { Link, useForm, usePage, router } from '@inertiajs/vue3';
    import { computed } from 'vue';

    const page = usePage()
    const user = computed(() => page.props.auth.user)
    const fileReady = computed(() => page.props.flash.fileReady ? true : false);
    const fileData = computed(() => page.props.flash.fileReady || null);
    const downloads = computed(() => page.props.userDownloads)

    const form = useForm({
        url: null,
        format: 'mp4',
        quality: null,
    });

    const submit = () => {
        form.post(route('home'));
        form.reset('url');
    };

    const deleteDownload = (id) => {
        router.delete(route('download.delete', {id: id}),
        { preserveScroll: true });
    };

    function formatDate(isoString) {
        // 1. Handle null, undefined, or empty string input
        if (!isoString) {
            return 'Error: Input is empty.';
        }

        // 2. Create a Date object from the ISO string.
        const date = new Date(isoString);

        // 3. Validate the Date object (check if it resulted in "Invalid Date")
        if (isNaN(date.getTime())) {
            return 'Error: Invalid Date Format (must be ISO 8601).';
        }

        // 4. Define formatting options for a clear, readable output.
        const options = {
            year: 'numeric',
            month: 'short',     // e.g., Nov
            day: '2-digit',     // e.g., 13
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true,       // e.g., PM/AM
            timeZoneName: 'short', // e.g., GMT, PST, EST
        };

        // 5. Use toLocaleString for reliable, locale-aware formatting.
        try {
            return date.toLocaleString('en-US', options);
        } catch (error) {
            // Fallback error handling
            return 'Error: Could not format date.';
        }
    }

</script>

<template>

    <Head :title="`- ${$page.component}`" />
    <h1 class="search-title">Convert YouTube videos for free!</h1>
    <form class=" search-form" @submit.prevent="submit">
        <div class="form-section search-bar">
            <label for="yt-url" class="sr-only">YouTube URL</label>
            <input id="yt-url" name="url" type="text"
                :placeholder="form.errors.url ? 'Enter valid URL...' : 'Paste YouTube link...'" aria-label="YouTube URL"
                :class="form.errors.url ? 'search-input error' : 'search-input'" required v-model="form.url" />
            <button type="submit" class="go-buttton">Go</button>
        </div>
        <div class="form-section search-settings">
            <label for="format-select" class="settings-label">Format</label>
            <select id="format-select" name="format" class="format-select drop-down"
                onchange="document.getElementById('quality-select').disabled = (this.value !== 'mp4')"
                v-model="form.format">
                <option value="mp4" selected>MP4 (video)</option>
                <option value="mp3">MP3 (audio)</option>
            </select>
            <span class="spacer"></span>
            <label for="quality-select" class="settings-label">Video quality</label>
            <select id="quality-select" name="quality" class="quality-select drop-down" aria-label="Video quality"
                v-model="form.quality">
                <option :value="null" selected>best</option>
                <option value="1080p">1080p</option>
                <option value="720p">720p</option>
                <option value="480p">480p</option>
                <option value="360p">360p</option>
                <option value="144p">144p</option>
            </select>
        </div>
    </form>
    <div class="output-section" v-if="fileReady">
        <h2 class="output-title">Your file is ready!</h2>
        <p class="output-description">{{ fileData.name }}</p>
        <a :href="route('file.download', { name: fileData.name })" class="download-link" as="button">Download</a>
        <Link :href="route('file.delete')" method="post" as="button" class="delete-link">Delete</Link>
    </div>
    <div class="login-prompt" v-if="!user">
        <p>
            To keep track of your previous downloads and access them anytime!
        </p>
        <p>
            <Link :href="route('login')" class="login-link">Login</Link> or
            <Link :href="route('register')" class="login-link">Register</Link> here!
        </p>
    </div>
    <div v-else>
        <div class="download-history">
            <!-- Header -->
            <h2 class="download-title">
                Download History
            </h2>
            <!-- Empty State -->
            <div v-if="!downloads || downloads.length === 0" class="downloads-container">
                <svg class="no-downloads-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <h3 class="no-downloads-subtitle">No Downloads Yet</h3>
                <p class="no-downloads-description">
                    Your download history will appear here once you've completed a download.
                </p>
            </div>

            <!-- Download List (v-for) -->
            <div v-else class="space-y-4">
                <div v-for="download in downloads" :key="download.id" class="download-entry">
                    <!-- Name & Format (Left/Top) -->
                    <div class="flex-1 min-w-0 mb-2 sm:mb-0 pr-4">
                        <p class="download-name" :title="download.name">
                            {{ download.name }}
                        </p>
                        <span class="download-info">
                            {{ download.format || 'Unknown Format' }}
                        </span>
                        <span v-if="download.format === 'mp4'" class="download-info">
                            {{ download.quality ? download.quality : 'best quality' }}
                        </span>
                    </div>
                    <!-- Date & Actions (Right/Bottom) -->
                    <div class="download-date-container">
                        <!-- Date -->
                        <p class="download-date">
                            Downloaded: {{ formatDate(download.created_at) }}
                        </p>

                        <!-- Optional Action Button (e.g., re-download) -->
                        <button  type="button" @click="deleteDownload(download.id)"
                            class="delete-download">
                            Delete
                            <svg class="delete-download-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button >
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- if logged in list of previous downloads with quick convert buttons -->
    <!-- quick convert coming soon as I want to deliver the project asap -->
    <!-- else propmt to login or register -->
</template>