<script setup>

</script>

<template>
    <Head :title="`- ${$page.component}`"/>
    <div>
        <div class="about-section">
            <div class="about-container">
                <h1 class="about-title">About FFDLP</h1>
                
                <div class="about-content">
                    <section>
                        <h2 class="about-block-title">Project Overview</h2>
                        <p class="about-block">
                            FFDLP <a href="https://github.com/Dranelmek/LaraVue-showcase" target="_blank">(LaraVue Showcase)</a> is a full-stack web application built to demonstrate proficiency with Laravel and Vue.js. 
                            It's a practical CRUD platform that allows users to download video and audio content from YouTube while 
                            maintaining a personalized history of their previous downloads.
                        </p>
                    </section>

                    <section>
                        <h2 class="about-block-title">Technology Stack</h2>
                        <ul class="about-block-list">
                            <li>• <strong>Backend:</strong> Laravel - for robust server-side logic and API endpoints</li>
                            <li>• <strong>Frontend:</strong> Vue.js - for interactive and reactive user interfaces</li>
                            <li>• <strong>Integration:</strong> Inertia.js - seamless server-driven UI updates</li>
                            <li>• <strong>Styling:</strong> Tailwind CSS - for modern, responsive design</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="about-block-title">Development Philosophy</h2>
                        <p class="about-block">
                            Every line of code in this project has been carefully crafted with full understanding of its purpose. 
                            While leveraging Inertia.js for efficiency, the architecture closely follows traditional Laravel + Vue.js 
                            workflows to ensure solid fundamentals and best practices.
                        </p>
                    </section>

                    <section>
                        <h2 class="about-block-title">Purpose</h2>
                        <p class="about-block">
                            This project was created to showcase technical capabilities to the hiring team at Teemill, 
                            demonstrating competence in full-stack development, API design, and modern front-end frameworks.
                        </p>
                    </section>
                </div>
            </div>
        </div>
        
    </div>
</template>