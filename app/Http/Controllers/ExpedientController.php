<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Laracasts\Flash\Flash;
use Illuminate\Http\Response;
use Carbon\Carbon;
use App\Expedient;
use App\File;
use App\User;
use App\Year;
use App\Type;
use App\Pass;
use Auth;

class ExpedientController extends Controller
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
      // permisos

        if( Auth::user()->can('expedient_list')){

          // si es proveyente traigo los exptedientes que le fueron asignados
          if (Auth::user()->hasRole('proveyente')) {
            $expedients = Expedient::whereUserOwnerId(Auth::user()->id)->get();
          }else {
            // si no, muestro todos
            $expedients = Expedient::get();
          }

          return view('expedients.index')
                        ->withExpedients($expedients);
        }else {
          Flash::warning('no tiene permisos');
          return redirect()->back();
          //abort(403, 'No tiene permisos para Listar Expedientes.-');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

      if (!Auth::user()->can('expedient_create')) {
        //si no tiene permiso para creaer expedientes
        Flash::error('<strong> Permiso Denegado.-</strong>');
        return redirect()->back();
      }

      $usersOwner = User::whereNotIn('id',[1])->pluck('display_name','id');
      $years = Year::pluck('number','id');
      $types = Type::pluck('name','id');
      $selected = Carbon::now()->format('Y');
      return view('expedients.create')
                      ->withYears($years)
                      ->withTypes($types)
                      ->withUserOwner($usersOwner)
                      ->withSelected($selected);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      // control sobre la funcion
      if (!Auth::user()->can('expedient_create') ){
        abort(403);
      }
      // validaciones
      request()->validate([
        'title' => 'required|string|min:10',
        'number' => 'required|unique:expedients|numeric',
      ]);

      // si pasa la validacion creo el expte
      try {

        DB::beginTransaction();

          $expedient = Expedient::create([
            'number' => $request->input('number'),
            'title' => $request->input('title'),
            'year_id' => $request->input('year_id'),
            'type_id' => $request->input('type_id'),
            'user_create_id' => Auth::user()->id,
            'user_owner_id' => $request->user_owner_id
          ]);

          Pass::create([
            'expedient_id' => $expedient->id,
            'user_receiver_id' => $request->user_owner_id,
            'user_sender_id' => Auth::user()->id,
            'observation' => $request->input('observation'),
          ]);

        DB::commit();

        flash::success('Expediente creado Correctamente.-');
        return redirect('expedients');

      } catch (\Exception $e) {

        DB::rollback();

        flash::error('Fallo la creación del expte.-');
        return redirect('expedients');

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
      // control sobre la funcion
      if (!Auth::user()->can('expedient_show') ){
        abort(403);
      }
      $expedient = Expedient::find($id);
      return view('expedients.show')
        ->withExpedient($expedient);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      // control sobre la funcion
      if (!Auth::user()->can('expedient_edit') ){
        abort(403);
      }
      $years = Year::pluck('number','id');
      $expedient = Expedient::find($id);
      return view('expedients.edit')
        ->withExpedient($expedient)
        ->withYears($years);
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
      // control sobre la funcion
      if (!Auth::user()->can('expedient_edit') ){
        abort(403);
      }
      $expedient = Expedient::find($id);
      $expedient->title = $request->input('title');
      $expedient->number = $request->input('number');
      $expedient->year_id = $request->input('year_id');
      $expedient->user_create_id = Auth::user()->id;
      $expedient->save();

      return redirect()->route('expedients.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      // control sobre la funcion
      if (!Auth::user()->can('expedient_destroy') ){
        abort(403);
      }

      return $id;
    }

    public function receive($id)
    {

      $expedient = Expedient::find($id);
      $pass = $expedient->passes()->whereReceivedAt(null)->first();
      $pass->received_at = date('Y-m-d H:i:s');
      // $pass->receiver_at = \Carbon::now();
      $pass->save();
      //dd( $pass->receiver_at);

      return redirect()->back();

    }

    public function addFile(Request $request,$id){

      request()->validate([
        'title_file' => 'required|string',
        'file' => 'required|mimes:pdf,doc,docx',
      ]);


      //obtenemos el campo file definido en el formulario
       $file = $request->file('file');

       //obtengo los datos del archivo

       //nombre
       $nombre = $file->getClientOriginalName();
       //extension
       $extension = $file->getClientOriginalExtension();

       $destination = public_path().'/files/'.$id.'/';

       //existe el destino?
       if (!file_exists($destination)) {
          mkdir($destination, 0777, true);
        }

       $files_name = $nombre;
       $file->move($destination,$files_name);

        //creo un Documento
        $file = new File();
        $file->title = $request->title_file;
        $file->name = $files_name;
        $file->url = $destination;
        $file->expedient_id = $id;
        $file->user_id = Auth::user()->id;

        //dd($file);
        $file->save();

        return redirect()->back();

    }

    public function download($id,$files_id){

      $file = File::find($files_id);
      $name = $file->name;

      //PDF file is stored under project/public/download/info.pdf
      $file= public_path(). '/files/'.$id.'/'.$file->name;
      $headers = array(
                'Content-Type: application/pdf',
              );

      return response()->download($file, $name, $headers);
    }

    public function destroyFile($expedient_id,$file_id) {

      $file = File::find($file_id);
      $file_path = public_path(). '/files/'.$expedient_id.'/'.$file->name;

      if ($file->exists($file_path)) {

          // elimino datos de la DB
          $file->destroy($file_id);
          //elimino el archivo fisico
          unlink($file_path);

          Flash::success('<strong> Archivo eliminado correctamente.-</strong>');
          return redirect()->back();

      }else {
        Flash::warning('<strong> Archivo Inexistente.-</strong>');
        return redirect()->back();
      }
      //$file->delete();
      //return redirect('admin/dashboard')->with('message','خبر موفقانه حذف  شد');
    }
}
