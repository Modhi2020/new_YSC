<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    
    protected function authenticated($request, $user)
    {
        // if ($user->hasRole('Admin')) {

        //     $this->redirectTo = route('admin.dashboard');

        // } elseif ($user->hasRole('Agent')) {

        //     $this->redirectTo = route('agent.dashboard');

        // } elseif ($user->hasRole('User')) {

        //     $this->redirectTo = route('user.dashboard');
        // }

        if ($user->hasRoles('Owner')) {

            $this->redirectTo = route('admin.dashboard');

        } 
        elseif ($user->hasRoles('Admin')) {

            $this->redirectTo = route('admin.dashboard');

        } 
        elseif ($user->hasRoles('Manager')) {

            $this->redirectTo = route('admin.dashboard');

        } 
        elseif ($user->hasRoles('Supervisor')) {

            $this->redirectTo = route('admin.dashboard');

        } 
        elseif ($user->hasRoles('Teacher')) {

            $this->redirectTo = route('agent.dashboard');

        } 
        elseif ($user->hasRoles('Student')) {

            $this->redirectTo = route('user.dashboard');
        }
        elseif ($user->hasRoles('User')) {

            $this->redirectTo = route('user.dashboard');
        }
    }
}
