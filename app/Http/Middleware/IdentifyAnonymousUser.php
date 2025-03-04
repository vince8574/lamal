<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class IdentifyAnonymousUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $current = Cookie::get('token');
        if (blank($current)) {
            $current = cookie('token', (string) str()->uuid(), 60 * 24 * 90);

            Cookie::queue($current);
            $current = $current->getValue();
        }

        return $next($request);
    }
}
