<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage()
const user = computed(() => page.props.auth.user)

const form = useForm({
    url: null,
    format: 'mp4',
    quality: '1080p',
});

const submit = () => {
    form.post(route('home'));
    form.reset('url');
};

</script>


<template>
    <Head :title="`- ${$page.component}`"/>
    <h1 class="search-title">Convert YouTube videos for free!</h1>
    <form class=" search-form" @submit.prevent="submit">
        <div class="form-section search-bar">
            <label for="yt-url" class="sr-only">YouTube URL</label>
            <input id="yt-url" name="url" type="text" :placeholder="form.errors.url?'Enter valid URL...':'Paste YouTube link...'" aria-label="YouTube URL"
            :class="form.errors.url?'search-input error':'search-input'" required v-model="form.url"/>
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
                <option value="1080p" >1080p</option>
                <option value="720p">720p</option>
                <option value="480p">480p</option>
                <option value="360p">360p</option>
                <option value="144p">144p</option>
            </select>
        </div>
    </form>
    <div class="login-prompt" v-if="!user">
        <p>
            To keep track of your previous downloads and access them anytime!
        </p>
        <p>
            <Link :href="route('login')" class="login-link">Login</Link> or
            <Link :href="route('register')" class="login-link">Register</Link> here!
        </p>
    </div>

    <!-- if logged in list of previous downloads with quick convert buttons -->
    <!-- else propmt to login or register -->
</template>

<!-- TODO: make homepage and learn backend -->