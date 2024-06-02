<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permissionName): Response
    {
        // check if the given permission is contained with user's permissions
        if(auth()->user()?->permissions?->contains('name', $permissionName)){
            // if so , complete request and redirected to desired page
            return $next($request);
        }
        return response()->json(['error' => 'Not permitted!']);
    }
}
