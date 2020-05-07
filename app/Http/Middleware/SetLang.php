<?php

namespace App\Http\Middleware;

use Closure;
use App;
use App\Helpers\LangHelper;

class SetLang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $lang = LangHelper::$defaultLang;

        if (request()->session()->has('lang')) {
            $lang = request()->session()->get('lang');
        }

        App::setLocale($lang);

        return $next($request);
    }
}
