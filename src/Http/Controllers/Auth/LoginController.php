<?php

namespace reactmay\WoWAuth\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Lang;

/**
 * Class LoginController
 *
 * @category Controller
 * @package  reactmay\WoWAuth\Http\Controllers\Auth
 * @link     https://github.com/reactmay/wow-auth
 */
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

	protected $username;
	
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
	
	public function username()
    {
        return 'username';
    }
	
	public function showLoginForm()
    {
        $data = [
            'title' => Lang::get('auth.login_link')
        ];

        return view('auth.login', $data);
    }
}
