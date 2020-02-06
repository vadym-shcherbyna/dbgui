<?php

	namespace App\Http\Controllers\auth;

	use App\Http\Controllers\Controller;
	
	use Validator;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;		
	
	use App\User;

	class AuthController extends Controller {
		
		public function loginForm() {
			
			if (Auth::check()) {
				
				return redirect(route('crud'));
				
			}
			else {
			
				return view('auth.login');
				
			}
			
		}

		public function loginPost(Request $request) {
			
			// validator
			
			$validator = Validator::make($request->all(), [
			
				'email' => 'required|string|email|max:191',
				
				'password' => 'required|string|max:191',
				
				'remember' => 'boolean',

			]);

			if ($validator->fails()) {
				
				return redirect(route('login'))->withErrors($validator)->withInput();
				
			}			
			
			// Check "remember" flag
			
			$remember = false;
			
			if ($request->input('remember')) {
				
				$remember = true;
					
			}
			
			// Auth or create
			
			$users = User::where('user_group_id', 1)->get();
			
			if ($users->count() > 0) {
				
				// Auth admin 
				
				// Credentials array 
			
				$credentials = [
			
					'email' => $request->input('email'),
				
					'password' => $request->input('password'),
				
					'user_group_id' => 1
			
				];
			
				// Check auth
			
				if (Auth::attempt($credentials, $remember)) {				
            
					return redirect(route('crud'));
				
				}
				else {
					
					return redirect(route('login'))->withInput();
					
				}
				
			}
			else {
				
				// Create admin 
				
				$User = User::create([
								
					'email' => $request->input('email'),
					'password' => bcrypt($request->input('password')),
					'user_group_id' => 1
				
				]);				
				
				Auth::login($User, true);
							
				return redirect(route('crud'));
				
			}
			
		}		
		
		public function logout() {
			
			Auth::logout();	
			
			return redirect(route('login'));
				
		}
		
		
		
	}
