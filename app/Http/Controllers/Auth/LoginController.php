<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laracasts\Flash\Flash;
use App\User;
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
        $d = Auth::attempt($credenciales);
        //dd($d);
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

    public function FormResetPass($id)
    {
      return view('auth.passwords.reset')->withId($id);
    }

    public function resetPass($user_id = null)
    {
      request()->validate([
        'password' =>'required|min:6|same:password',
        'password-confirm' =>'required|min:6|same:password',
      ]);

      if ($user_id) {
        $id = $user_id;
      }else {
        $id = Auth::user()->id;
      }
      $user = User::find($id);
      $user->password = bcrypt(request()->input('password'));
      $user->save();

      Flash::success('Su contraseña se cambio satisfactoriamente');
      return redirect('expedients');

    }

}
