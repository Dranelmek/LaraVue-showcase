<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    url: null,
    format: 'mp4',
    quality: '1080p',
});

const submit = () => {
    form.post(route('home'));
};
</script>

<template>
    <Head :title="`- ${$page.component}`"/>
    <h1 class="search-title">Convert YouTube videos for free!</h1>
    <form class=" search-form" @submit.prevent="submit">
        <div class="form-section search-bar">
            <label for="yt-url" class="sr-only">YouTube URL</label>
            <input id="yt-url" name="url" type="text" placeholder="Paste YouTube link..." aria-label="YouTube URL"
            class="search-input" required v-model="form.url"/>
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
                <option value="1080p" selected>1080p</option>
                <option value="720p">720p</option>
                <option value="480p">480p</option>
                <option value="360p">360p</option>
                <option value="144p">144p</option>
            </select>
        </div>
        
        
    </form>
    <!-- Search bar form to paste yt link and go button -->
    <!-- if logged in list of previous downloads with quick convert buttons -->
    <!-- else propmt to login or register -->
</template>

<!-- TODO: make homepage and learn backend -->