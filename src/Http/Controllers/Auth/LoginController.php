<?php

namespace reactmay\WoWAuth\Http\Controllers\Auth;

use Illuminate\Http\Request;
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

    use AuthenticatesUsers {
        redirectPath as laravelRedirectPath;
    }

    public function redirectPath()
    {
        // Do your logic to flash data to session...
        toastr()->success('Auth successfully');

        // Return the results of the method we are overriding that we aliased.
        return $this->laravelRedirectPath();
    }

	protected $username;
	
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

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
        $intendedURL = \Session::get('url.intended');

        if($intendedURL) {
            toastr()->error('Необходимо войти в систему');
        }

        $data = [
            'title' => Lang::get('auth.login_link')
        ];

        return view('auth.login', $data);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required|captcha'
        ]);
    }
}
