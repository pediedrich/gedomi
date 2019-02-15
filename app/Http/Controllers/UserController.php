<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Validator;
use App\User;
use App\Role;
use Auth;

class UserController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if ( Auth::user()->can('user_create')) {
            $users = User::paginate(7);
            return view('users.index',compact('users'));
        } else {
          abort(403);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      if (Auth::user()->can('user_create')) {
          $roles = Role::whereNotIn('id',[1])->pluck('name','id');
          return view('users.create',compact('roles'));
      } else {
          abort(403);
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      if (Auth::user()->can('user_create')) {
        // create the validation rules
        $rules = array(
          'display_name' => 'required|string',
          'name' => 'required|unique:users|max:15|min:5',
          'email' => 'required|email|unique:users',
        );

        // do the validation
        // validate against the inputs from our form
        $validator = Validator::make($request->all(), $rules);

          // check if the validator failed
          if ($validator->fails()) {

              // get the error messages from the validator
              $messages = $validator->messages();

              Flash::error('Se encontraron errores al procesar el formulario!');
              return redirect()->back()->withInput()->withErrors($messages);

          } else {
              $user = new User();
              $user->email = $request->get('email');
              $user->name = $request->get('name');
              $user->display_name = $request->get('display_name');
              $user->password = bcrypt($request->get('name'));
              $user->save();

              $user->roles()->detach();
              $user->attachRole(Role::find($request->get('rol_id')));

              Flash::success('Se guardó correctamente!');
              return redirect()->route('users.index');
          }
      } else {
        abort(403);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      if (Auth::user()->can('user_edit')) {
          $roles = Role::pluck('name','id');
          $user = User::find($id);
          return view('users.edit',compact('roles','user'));
      } else {
          abort(403);
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      if (Auth::user()->can('user_edit')) {
        // create the validation rules
        $rules = array(
          'display_name' => 'required|string',
          'name' => 'required|unique:users|max:15|min:5',
          'email' => 'required|email',
        );

        // do the validation
        // validate against the inputs from our form
        $validator = Validator::make($request->all(), $rules);

          // check if the validator failed
          if ($validator->fails()) {

              // get the error messages from the validator
              $messages = $validator->messages();

              Flash::error('Se encontraron errores al procesar el formulario!');
              return redirect()->back()->withInput()->withErrors($messages);

          } else {
              $user = new User();
              $user->email = $request->get('email');
              $user->name = $request->get('name');
              $user->display_name = $request->get('display_name');
              $user->password = bcrypt($request->get('name'));
              $user->save();

              $user->roles()->detach();
              $user->attachRole(Role::find($request->get('rol_id')));

              Flash::success('Se guardó correctamente!');
              return redirect()->route('users.index');
          }
      } else {
        abort(403);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        flash('Se elimino correctamente!')->success();
        return redirect('users');
    }
}
