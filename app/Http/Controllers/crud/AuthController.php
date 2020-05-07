<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\crud\PageController;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class AuthController extends PageController
{
    /**
     * Controller for login page
     *
     * @return Response
     */
    public function loginForm()
    {
        if (Auth::check()) {
            //
            return redirect(route('dashboard'));
        } else {
            //
            return $this->view('auth.login');
        }
    }

    /**
     * Controller  for  submiting login form
     * Create new user account | Create  new admin  account  | Auth
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function loginPost(Request $request)
    {
        // validator
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:191',
            'password' => 'required|string|max:191',
            'remember' => 'boolean',
        ]);

        // Return login form with  errors
        if ($validator->fails()) {
            return redirect(route('auth.login'))->withErrors($validator)->withInput();
        }

        // Check "remember" flag
        $remember = false;
        if ($request->input('remember')) {
            $remember = true;
        }

        // Auth user  or create  new  user
        $users = User::where('user_group_id', 1)->get();

        // Create new  account with user rules
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
                return redirect(route('dashboard'));
            } else {
                return redirect(route('auth.login'))->withInput();
            }
        } else {
            // Create new  account with admin rules
            $User = User::create([
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'user_group_id' => 1
            ]);

            //  Auth new  account and  redirect  to  crud area
            Auth::login($User, true);
            return redirect(route('dashboard'));
        }
    }

    /**
     * Controller  for  logout action + redirect to login  page
     *
     * @return Illuminate\Support\Facades\Redirect
     */
    public function logout()
    {
        Auth::logout();
        return redirect(route('auth.login'));
    }
}
