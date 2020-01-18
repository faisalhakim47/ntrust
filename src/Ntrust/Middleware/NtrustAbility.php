<?php

namespace Klaravel\Ntrust\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class NtrustAbility
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param $roles
     * @param $permissions
     * @param bool $validateAll
     * @return mixed
     */
    public function handle($request, Closure $next, $roles, $permissions, $validateAll = false)
    {
        $ability_validated = $request
            ->user()
            ->ability(explode('|', $roles), explode('|', $permissions), [
                'validate_all' => $validateAll
            ]);

        if (auth()->guest() || !$ability_validated) {
            abort(403);
        }

        return $next($request);
    }
}
