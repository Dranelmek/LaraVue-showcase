<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Notes
I this section I'll keep notes to myself and when the project is done I will adapt the entire readme

when live shell commands are executed from *\LaraVue-showcase\public so yt-dlp and ffmpeg need to be installed in that folder.

Ensure that the php installation is configured to allow zip extensions and the max execution time is forgiving (e.g. 300)

### Project scope
This will be a simple CRUD site using Laravel for it's back end and Vue.js for it's frontend with Inertia for vue integration.
The site will allow users to access the features of [FFDLP](https://github.com/Dranelmek/ffdlp) via their webbrowser.
Note that this means all the logic originally implemented in Python will need to be rewritten in PHP. 
The site will support account creation, data tracking, cookies and url parsing.
Future developments beyond this demonstration could include:
    - better security
    - ddos protection
    - rate limits for users
    - a subscription model
    - implement more failsafes for bad requests
    - proper scheduling to handle many users at once
    - making a db migration to store the url of a download
      so users can reconvert a video they converted previously
#### Known bugs for future fixing
    - double clicking the logout button results in a session timeout
