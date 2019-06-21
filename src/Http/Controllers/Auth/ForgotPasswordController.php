<?php

namespace reactmay\WoWAuth\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Lang;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

/**
 * Class ForgotPasswordController
 *
 * @category Controller
 * @package  reactmay\WoWAuth\Http\Controllers\Auth
 * @link     https://github.com/reactmay/wow-auth
 */
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm()
    {
        $data = [
            'title' => Lang::get('auth.page_reset_password')
        ];

        return view('ucp.passwords.email', $data);
    }
}
