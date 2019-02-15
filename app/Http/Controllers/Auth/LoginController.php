<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;


class LoginController extends Controller
{

    //protected $redirectTo = '/expedients';

    public function __construct(){
      //$this->middleware('guest',['only',['showLoginForm']]);
    }

    public function showLoginForm(){
      return view('auth.login');
    }

    public function login()
    {
        $credenciales = $this->validate(request(),[
            $this->username() => 'required|string',
            'password' => 'required|string'
        ]);

        // return $credenciales;
        if (Auth::attempt($credenciales)) {
          return redirect()->route('expedients.index');
        }

        return back()
                  ->withErrors([$this->username() => trans('auth.failed')])
                  ->withInput(request([$this->username()]));

    }


    public function logout()
    {
      Auth::logout();

      return redirect('/');
    }

    public function username()
    {
      return 'name';
    }

}
