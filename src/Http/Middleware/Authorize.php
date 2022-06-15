<?php

namespace Eminiarts\NovaPermissions\Http\Middleware;

use Closure;
use Eminiarts\NovaPermissions\NovaPermissions;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, $next)
    {
        return resolve(NovaPermissions::class)->authorize($request) ? $next($request) : abort(403);
    }
}
