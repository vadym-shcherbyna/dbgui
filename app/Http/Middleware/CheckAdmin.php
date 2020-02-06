<?php

	namespace App\Http\Middleware;

	use Closure;
	
	use Illuminate\Support\Facades\Auth;

	class CheckAdmin {
    
		public function handle($request, Closure $next) {
		
			if (Auth::check()) {
					
				if (Auth::user()->user_group_id == 1) {
					
				}
				else {				
					
					return redirect(route('login'));
					
				}
				
			}						
			else {
				
				return redirect(route('login'));
				
			}					
						
			return $next($request);
			
		}
		
	}
