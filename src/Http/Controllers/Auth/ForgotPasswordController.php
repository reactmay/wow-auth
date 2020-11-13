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

    protected function rules()
    {
        if(env('APP_ENV') == 'production') {
            return [
                'email' => 'required|email',
                'g-recaptcha-response' => 'required|captcha'
            ];
        } else {
            return [
                'email' => 'required|email'
            ];
        }
    }

    public function sendResetLinkEmail(Request $request)
    {
        // стандартная проверка на email
//        $this->validateEmail($request);

        // моя проверка на почту и капчу
        $this->validate($request,
            [
                'email' => 'required|email',
                'g-recaptcha-response' => 'required|captcha'
            ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }
}
