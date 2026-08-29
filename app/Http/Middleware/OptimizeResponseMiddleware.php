<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OptimizeResponseMiddleware
{
    /**
     * Handle an incoming request and optimize response headers.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Optimize caching for built Vite assets, fonts, and static media
        $path = $request->path();
        if (str_starts_with($path, 'build/') || str_starts_with($path, 'images/')) {
            $response->headers->set('Cache-Control', 'public, max-age=31536000, immutable');
        }

        // Security & Performance Headers
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        return $response;
    }
}
