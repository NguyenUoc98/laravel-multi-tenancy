<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;

class ThrottleRequests extends \Illuminate\Routing\Middleware\ThrottleRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int|string  $maxAttempts
     * @param  float|int  $decayMinutes
     * @param  string  $prefix
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Http\Exceptions\ThrottleRequestsException
     */
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1, $prefix = '')
    {
        if ($request->getHost() === config('app.domain')) {

            // if Host is 'laravel.test' set DB connection to 'landlord'
            config(['database.default' => 'landlord']);
            config(['platform.guard' => 'admin']);
            auth()->shouldUse('admin');
        }

        return parent::handle($request, $next);
    }
}
