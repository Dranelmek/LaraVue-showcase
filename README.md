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

- Shell commands used by the application are executed from the project `public/` directory (Windows: `\LaraVue-showcase\public`). Ensure that `yt-dlp` and `ffmpeg` are installed and accessible either in the `public/` directory or on the system PATH.
- PHP must include the Zip extension and be configured to allow long-running requests where appropriate. Set `max_execution_time` to a higher value (for example, `300` seconds) in `php.ini` or via runtime configuration.
- Ensure required system dependencies and permissions are configured before running the application.

### Project scope

This project is a demonstration CRUD application using Laravel as the backend and Vue.js with Inertia for the frontend. The application exposes FFDLP functionality via a web interface, which requires porting the original Python logic to PHP.

Core features:
- User registration, authentication, and session management
- Data tracking and basic analytics for user activity
- Cookie handling and URL parsing for download/conversion workflows
- Server-side conversion and media processing integration (via `yt-dlp` / `ffmpeg`)

Potential future improvements:
- Harden security (input validation, CSRF/authorization hardening)
- DDoS mitigation and request throttling
- Per-user rate limits and quotas
- Subscription or billing model
- Additional request validation and fail-safes
- Scalable scheduling/queueing for concurrent conversions
- Database migrations to persist download metadata and enable re-conversion
- Logging and testing

### Known issues

- Double-clicking the logout button may cause a session timeout. Investigate debouncing the logout action or disabling the button after the first click.
