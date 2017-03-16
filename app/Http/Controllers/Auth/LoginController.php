<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    use AuthenticatesUsers { login as protected traitLogin; }

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


    public function index() {
        return view('login');
    }

    //override para passar parametro de ativo
    public function login(Request $request) {
        $request->merge(['ativo'=>1]);
        //dd($request);
        return $this->traitLogin($request);
    }

    //override para passar parametro de ativo
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password', 'ativo');
    }

}
