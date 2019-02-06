<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;


class LoginController extends Controller
{

    protected $redirectTo = '/expedients';

    public function login(){
      $cred = $this->validate(request(),[
        'email' => 'required|string',
        'password' => 'required|string'
      ]);

      if (Auth::attempt($cred)){
        return redirect()->route('expedients.index');
      }
      return back()->withErrors(['email' => trans('auth.failed')]);
    }
}
