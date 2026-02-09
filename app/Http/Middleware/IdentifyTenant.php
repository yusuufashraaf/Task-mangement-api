<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $subdomain = $request->header('X-Tenant-ID');

        if (!$subdomain) {
            return response()->json(['error' => 'Tenant header missing'], 400);
        }

        $tenant = Tenant::where('subdomain', $subdomain)->firstOrFail();

        app()->instance('tenant', $tenant);

        return $next($request);
    }
}