<?php

namespace reactmay\WoWAuth\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Contracts\Hashing\Hasher as IlluminateHasher;
use Illuminate\Support\Str;
use Lang;

use Illuminate\Http\Request;

/**
 * Class ResetPasswordController
 *
 * @category Controller
 * @package  reactmay\WoWAuth\Http\Controllers\Auth
 * @link     https://github.com/reactmay/wow-auth
 */
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;


    /**
     * Instance of the WoW password hasher
     *
     *
     * @var SHA1Hasher
     */
    protected $hasher;



    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(IlluminateHasher $hasher)
    {
        $this->hasher = $hasher;
        $this->middleware('guest');
    }

    protected function resetPassword($user, $password){
        $data = [
            'sha_pass_hash'  => $this->hasher->make([
                'username' => $user->username,
                'password' => $password]),
            'remember_token' => Str::random(60),
			'v' => '',
            's' => '',
            'sessionkey' => ''
        ];

        if(config('wow-auth.passport')){
            $data['password'] = md5($password);
        }

        $user->forceFill($data)->save();
    }

    public function showResetForm(Request $request, $token = null)
    {
        $data = [
            'title' => Lang::get('auth.page_change_password')
        ];

        return view('auth.passwords.reset', $data)->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
