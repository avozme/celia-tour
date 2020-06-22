<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\Option;
use Illuminate\Support\Facades\Session;

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
    protected $redirectTo = '/zone';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        if(Option::where('id', 20)->get()[0]->value =="Si"){
            Session::put('escape', true);
        }else{
            Session::put('escape', false);
        }
    }

    //--------------------------------------------------------------

    /**
     * METODO PARA CERRAR SESIÓN
     */
    public function logout() { 
        Auth::logout(); 
        Session::flush(); 
        return redirect('/'); 
    } 
}
