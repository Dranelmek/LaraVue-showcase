<script setup>
defineProps({
    user: String
});
</script>

<template>
    <Head :title="`- ${$page.component}`"/>
    <div>
        <h1>About</h1>
        <p>This is the about page for {{ user }}.</p>
    </div>
</template>