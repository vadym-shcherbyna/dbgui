<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * Mutate field before  adding in database
     *
     * @param  \Illuminate\Http\Request $request
     * @param Closure  $next
     * @return Closure
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->user_group_id == 1) {

            } else {
                return redirect(route('login'));
            }
        } else {
            return redirect(route('login'));
        }

        return $next($request);
    }
}
