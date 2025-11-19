<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    /**
     * This middleware forces https for the website making it work when compilled in render.com
     * 
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->server->set('HTTPS', 'on');
        $request->headers->set('X-Forwarded-Proto', 'https');

        return $next($request);
    }
}
