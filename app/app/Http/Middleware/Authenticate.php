<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }

    public function handle($request, Closure $next, ...$guards)
    {
        if($token = $request->cookie('cookie_token')){
            $request->headers->set('Authorization', 'Bearer '.$token);
        }
        $this->authenticate($request, $guards);

        return $next($request);
    }
}
