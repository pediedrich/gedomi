<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Auth;

use App\Movement;
use App\Expedient;
use App\Pass;



class MovementController extends Controller
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
  public function index($id)
  {
    $expedient = Expedient::findOrFail($id);
    $movements = $expedient->movements()->orderBy('created_at','desc')->get();
    $passes = $expedient->passes()->orderBy('created_at','desc')->get();

    return view('movements.index',compact('movements','expedient','passes'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create($id)
  {
    $expedient = Expedient::findOrFail($id);
    return view('novelties.create',compact('expedient'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store($id,Request $request)
  {
    $expedient = Expedient::findOrFail($id);
    //valido los campos requeridos
    request()->validate([
      'title' => 'required|string',
      'text' => 'required|string',
    ]);


    if ($request->estado) {
      $estado = true;
    }
    else {
      $estado = false;
    }

    $novelty = Novelty::create([
      'title' => $request->title,
      'expedient_id' => $id,
      'text' => $request->text,
      'public' => $estado,
      'user_id' => Auth::user()->id,
    ]);
    return redirect()->route('expedient.novelties',array('id' => $id,'expedient'=>$expedient));
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
    $novelty = Novelty::findOrFail($id);
    return view('novelties.edit',compact('novelty'));
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

    //valido los campos requeridos
    request()->validate([
      'title' => 'required|string',
      'text' => 'required|string',
    ]);


    if ($request->estado) {
      $estado = true;
    }
    else {
      $estado = false;
    }

    $novelty = Novelty::findOrFail($id);
    $novelty->title = $request->title;
    $novelty->text = $request->text;
    $novelty->public = $estado;
    $novelty->user_id = Auth::user()->id;
    $novelty->update();

    return redirect()->route('expedient.novelties',array('id' => $novelty->expedient_id));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $novelty = Novelty::findOrFail($id);
    $expedient_id = $novelty->expedient_id;
    $novelty->delete();

    Flash::success('Eliminado correctamente');
    return redirect()->route('expedient.novelties',array('id' => $expedient_id));
  }
}
