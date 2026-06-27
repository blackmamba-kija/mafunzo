<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleCors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedOrigins = [
            'http://localhost:8080',
            'http://127.0.0.1:8080',
            'http://localhost:8081',
            'http://127.0.0.1:8081',
        ];

        $origin = $request->headers->get('Origin');
        $allowedOrigin = in_array($origin, $allowedOrigins) ? $origin : $allowedOrigins[0];

        // Handle preflight OPTIONS requests immediately with CORS headers
        if ($request->getMethod() === 'OPTIONS') {
            return response('', 200, [
                'Access-Control-Allow-Origin'      => $allowedOrigin,
                'Access-Control-Allow-Methods'     => 'GET, POST, PUT, PATCH, DELETE, OPTIONS',
                'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With, X-XSRF-TOKEN, Accept, X-Course-Id',
                'Access-Control-Allow-Credentials' => 'true',
                'Access-Control-Max-Age'           => '86400',
            ]);
        }

        $response = $next($request);

        $response->headers->set('Access-Control-Allow-Origin', $allowedOrigin);
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, X-XSRF-TOKEN, Accept, X-Course-Id');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');

        return $response;
    }
}

