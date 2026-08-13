<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModuleAccessMiddleware
{
    public function handle(Request $request, Closure $next, string $module): Response
    {
        $requiredRole = config("permissions.$module", 'admin');
        $user = $request->user();

        if (!$user) {
            abort(403);
        }

        if ($requiredRole === 'staff') {
            return $next($request);
        }

        if ($user->role === 'admin') {
            return $next($request);
        }

        abort(403, 'Unauthorized.');
    }
}