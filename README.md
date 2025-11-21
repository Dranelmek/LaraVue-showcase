# FFDLP — Laravel + Vue.js Showcase Project

A full-stack media downloader demonstrating backend engineering, debugging skill, and production deployment.

#### 🖥️ Live Demo
🔗 https://ffdlp.onrender.com

FFDLP is a showcase application designed to demonstrate my ability to build, optimize, debug, and deploy a real-world full-stack application using Laravel 12, Vue.js, Inertia.js, and TailwindCSS.
It provides a clean web UI that allows users to download YouTube videos as audio (MP3) or video (multiple qualities), with server-side handling via yt-dlp and ffmpeg.

Although lightweight, the project integrates system-level processes, handles Unicode paths, performs server-side video conversions, and implements complete user authentication and CRUD history management.
____

#### ✨ Features

##### 🎬 Video & Audio Downloading
- Download YouTube videos directly from the browser
- Choose from multiple video qualities
- Extract and convert audio to MP3
- Server-side conversion using:
    - yt-dlp for media retrieval
    - ffmpeg for transcoding to MP4
- Automatic handling of non-ASCII filenames (e.g. Japanese titles)

#### 🙍‍♂️ User Accounts & History
- Email/username registration
- Secure login & session management
- Stores a user’s download history without storing the actual files (budget-friendly)
- One-click re-download using saved URLs
- Delete individual history entries (CRUD)

#### 🛠️ Technologies
- Laravel 12 - backend, routing, controllers, file handling, process management
- Vue.js + Inertia.js - reactive single-page experience
- TailwindCSS - clean and responsive UI
- MySQL/Postgres - user authentication & history storage
- yt-dlp / ffmpeg - media processing layer
- Render.com - deployment hosting

____

#### 🧠 What This Project Demonstrates (Skills Highlight)

##### 🎯 Backend Engineering
- Handling long-running tasks & timeouts
- Secure file management and cleanup
- Shell integration, escaping arguments, and managing Unicode filenames
- Input sanitization & request validation
- Debug logging and error handling

##### 🪲 Advanced Debugging
This project required extensive debugging of issues such as:
- Permission errors in containerized environments
- Large cookies.txt file handling (636 KB)
- Path encoding problems
- yt-dlp argument conflicts
- ffmpeg input option ordering
- Processing Unicode filenames (メズマライザー / 初音ミク・重音テトSV.mp4)
- Detecting and correcting blocking operations that prevented server responses

##### 🧩 General Problem-Solving & Logic
- Designing a clean CRUD flow
- Managing asynchronous tasks on a synchronous server
- Ensuring reactivity in UI state via Vue + Inertia
- Handling unpredictable third-party tool behavior
- Ensuring safe concurrency and clearing temp files
- Implementing cross-platform compatibility for local development

____

#### 📂 Project Overview
FFDLP is a full-stack CRUD application with a real-world use case:
- **Backend**: Laravel handles authentication, routing, history CRUD, and orchestrates media processing.
- **Frontend**: Vue + Inertia provides a smooth SPA-like experience with modern, clean UI components.
- **Media** Pipeline: yt-dlp downloads media; ffmpeg converts it to user-friendly formats.
This project adapts the underlying scripting logic of typical desktop downloaders into a fully hosted web service.  
Check out original [ffdlp](https://github.com/Dranelmek/ffdlp) project by Drane!

____

#### 📝 Notes & Requirements
- Shell commands are executed from the project `public/` directory (Windows: `\LaraVue-showcase\public`).
- Ensure `yt-dlp` and `ffmpeg` are installed and accessible on the system PATH or placed in `public/`.
- PHP must include the **Zip** extension.
- Increase `max_execution_time` when running long conversions (`300`+ seconds recommended).
- When deploying, ensure proper filesystem permissions for storage.

____

#### 🚀 Future Improvements
- Harden server security (validation, throttling, CSRF hardening)
- Add user-level rate limits
- Queue jobs for concurrent conversions
- Cloud-hosted file conversions for heavy workloads
- Activity analytics dashboard
- Subscription system for extended limits

____

#### ⚠️ Known Issues
- Double-clicking Logout may cause session errors (could include debouncing as a fix).
- Very long high-quality video downloads may exceed free-tier server timeouts.

____

#### 📸 Laravel Badge Section
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p> <p align="center"> <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a> </p>