<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleEnabled
{
    public function handle(Request $request, Closure $next, string $module): Response
    {
        if (!module_enabled($module)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Module not enabled.'], 403);
            }
            abort(403, "The {$module} module is not enabled.");
        }

        return $next($request);
    }
}
