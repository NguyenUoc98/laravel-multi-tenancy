<?php

namespace App\Http\Middleware;

use Closure;

class EnsureValidTenantSession extends \Spatie\Multitenancy\Http\Middleware\EnsureValidTenantSession
{
    /**
     * Handle an incoming request.
     *
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next): mixed
    {
        // Skip this middleware whenever the landlord is requested.
        if (config('database.default') === 'landlord') {
            return $next($request);
        }

        return parent::handle($request, $next);
    }
}
