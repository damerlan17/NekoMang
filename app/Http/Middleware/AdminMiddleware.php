<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        if (!$request->user()->isAdmin()) {
            abort(
                403,
                'У вас недостаточно прав для доступа к этой странице.'
            );
        }

        return $next($request);
    }
}
