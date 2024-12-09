<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class LanguageApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $lang = $request->header('Content-Language', 'ar');
        $availableLocales = array_keys(Config::get('app.available_locales', []));

        if (in_array($lang, $availableLocales)) {
            App::setLocale($lang);
            if (Auth::guard('api')->check()) {
                Auth::guard('api')->user()->update([
                    'lang' => $lang
                ]);
            }
            return $next($request);
        }

        return response()->json([
            'status' => Response::HTTP_BAD_REQUEST,
            'msg' => 'This language is not supported.',
        ], Response::HTTP_BAD_REQUEST);
    }
}
