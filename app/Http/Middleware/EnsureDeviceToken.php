<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class EnsureDeviceToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $request->cookie('device_token')) {
            $response->cookie(
                'device_token',
                Str::random(40),
                60 * 24 * 365 * 5, // 5 tahun
                null,
                null,
                $request->secure(),
                true // httpOnly
            );
        }

        return $response;
    }
}