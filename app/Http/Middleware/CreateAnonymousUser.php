<?php

namespace App\Http\Middleware;

use App\Actions\CreateAnonymousUserAction;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Str;
use Illuminate\Support\Facades\Cookie;

class CreateAnonymousUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $current = Cookie::get('token');
        if (filled($current)) {
            CreateAnonymousUserAction::make()->execute($current);
        }

        return $next($request);
    }
}
