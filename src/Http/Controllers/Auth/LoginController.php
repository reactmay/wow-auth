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

    use AuthenticatesUsers;

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

        return view('ucp.login', $data);
    }

    protected function validateLogin(Request $request)
    {
        if(env('APP_ENV') == 'production') {
            $request->validate([
                $this->username() => 'required|string',
                'password' => 'required|string',
                'g-recaptcha-response' => 'required|captcha'
            ]);
        } else {
            $request->validate([
                $this->username() => 'required|string',
                'password' => 'required|string'
            ]);
        }
    }

    public function authenticated()
    {
        $success_login_message = 'Авторизация - успешно!';
        session()->flash('message', $success_login_message);
        session()->flash('alert-type', 'success');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $success_logout_message = 'Выход из аккаунта - успешно!';
        session()->flash('message', $success_logout_message);
        session()->flash('alert-type', 'success');

        return $this->loggedOut($request) ?: redirect('/');
    }
}
