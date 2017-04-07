<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Usuario;
use Illuminate\Http\Request;

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

    use SendsPasswordResetEmails  { sendResetLinkEmail as protected traitSendResetLinkEmail; }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    //override para passar view correta
    public function showLinkRequestForm()
    {
        return view('esqueceu_senha');
    }

    //override para verificar se o usuario esta ativo antes de enviar email de reset
    public function sendResetLinkEmail(Request $request) {

        $user = Usuario::where('email', $request->get('email'))->first();

        if (!$user) {
            $erro = 'Usuário não encontrado';
        } elseif ($user->ativo > 0) {
            return $this->traitSendResetLinkEmail($request);
        } else {
            $erro = 'Usuário não está ativo';
        }

        return back()->withErrors(['email' => $erro]);

    }
}
