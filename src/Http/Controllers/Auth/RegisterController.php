<?php

namespace Reactmay\WoWAuth\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Contracts\Hashing\Hasher as IlluminateHasher;
use Lang;

use reactmay\WoWAuth\Models\Auth\Account;

/**
 * Class RegisterController
 *
 * @category Controller
 * @package  reactmay\WoWAuth\Http\Controllers\Auth
 * @link     https://github.com/reactmay/wow-auth
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Instance of the WoW password hasher
     *
     *
     * @var SHA1Hasher
     */
    protected $hasher;

    /**
     * Create a new authentication controller instance.
     *
     *
     * @param WoWHasher $hasher
     * @return void
     */
    public function __construct(IlluminateHasher $hasher)
    {
        $this->hasher = $hasher;
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if(env('APP_ENV') == 'production') {
            return Validator::make($data, [
                'username'  => 'required|alpha_dash|max:255|unique:auth.account',
                'email'     => 'required|email|max:255|unique:auth.account|unique:auth.account,reg_mail',
                'password'  => 'required|min:6|confirmed',
                'g-recaptcha-response' => 'required|captcha'
            ]);
        } else {
            return Validator::make($data, [
                'username'  => 'required|alpha_dash|max:255|unique:auth.account',
                'email'     => 'required|email|max:255|unique:auth.account|unique:auth.account,reg_mail',
                'password'  => 'required|min:6|confirmed',
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return WoWAccount
     */
    protected function create(array $data)
    {

        $account = [
            'username'  => strtolower($data['username']),
            'email'     => $data['email'],
            'pass_hash'  => $this->hasher->make([
                'username' => $data['username'],
                'password' => $data['password']
            ]),
            'reg_mail' => $data['email'],
            'expansion_id' => 1
        ];

        if(config('wow-auth.passport')){
            $account['password'] = md5($data['password']);
        }

        $success_register_message = 'Создание аккаунта завершено успешно, вы вошли в систему.';
        session()->flash('message', $success_register_message);
        session()->flash('alert-type', 'success');

        return Account::create($account);
    }
	
	public function showRegistrationForm()
    {
        $data = [
            'title' => Lang::get('auth.register_link')
        ];

        return view('ucp.register', $data);
    }
}
