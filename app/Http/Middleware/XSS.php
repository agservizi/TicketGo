<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Utility;

class XSS
{
    public function handle($request, Closure $next)
    {
        try {
            App::setLocale(getActiveLanguage());
        } catch (\Throwable $th) {
        }

        $input = $request->all();
        $request->merge($input);

        return $next($request);
    }
}
