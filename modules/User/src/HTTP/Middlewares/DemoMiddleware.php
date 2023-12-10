<?php

namespace Modules\User\src\HTTP\Middlewares;

use Illuminate\Http\Request;
use Closure;

class DemoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        echo "Demo middleware";
        return $next($request);
    }
}
