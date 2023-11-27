<?php

namespace App\Http\Middleware;

use App\Actions\HandlerResponse;
use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;

class CheckAccessMiddleware
{
    use HandlerResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $roles_and_permissions)
    {
        $user = User::find(auth()->guard('api')->user()->id);
        $roles_and_permissions_array = explode('|', $roles_and_permissions);

        foreach ($roles_and_permissions_array as $item) {

            if ($user->hasRole($item) || $user->hasPermissions($item)) {

                return $next($request);
            }
        }

        return $this->responseUnauthorized(
            message: 'Access Denied.',
            status_code: Response::HTTP_UNAUTHORIZED
        );
    }
}
