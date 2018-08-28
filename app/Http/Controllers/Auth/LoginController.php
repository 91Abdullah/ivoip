<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

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
    //protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectTo()
    {
        $role = Auth::user()->roles->first()->name;
        $route = null;
        switch ($role) {
            case 'Agent':
                $route = 'front.agent';
                break;
            case 'Reporter':
                $route = 'dashboard';
                break;
            case 'Outbound':
                $route = 'front.outbound';
                break;
            case 'Blended':
                $route = 'front.blended';
                break;
            default:
                abort(404);
                break;
        }
        return route($route);
    }
}
