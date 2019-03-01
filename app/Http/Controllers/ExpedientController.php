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
use App\TypeFile;
use App\Role;
use App\User;
use App\Type;
use App\Pass;
use App\State;
use App\Movement;
use Auth;
use App\Year;

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
          if (Auth::user()->hasRole('relator')) {
            $expedients = Expedient::whereUserOwnerId(Auth::user()->id)->andWhereNotIn('state_id',[3])->get();
          }else {
            // si no, muestro todos
            $expedients = Expedient::WhereNotIn('state_id',[3])->get();
            //return $expedients[0]->passes()->get()->last();
          }
          //creo la variable $create para ocupar la misma vista y no mostrar el boton de crear exptes
          $create = false;
          return view('expedients.index')
                        ->withCreate($create)
                        ->withExpedients($expedients);
        }else {
          Flash::warning('no tiene permisos');
          return redirect()->back();
        }
    }

    public function indexAssign()
    {
      // Muestro los expedientes para asignar y/o crear
        if( Auth::user()->can('expedient_create')){
          $expedients = Expedient::WhereNotIn('state_id',[3])->get();

          return view('expedients.index')
                        ->withExpedients($expedients);
        }else {
          Flash::warning('no tiene permisos');
          return redirect()->back();
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
      // $usersOwner = User::whereHas('roles', function($q){
      //   $q->where('name','relator');
      // })->pluck('display_name','id');

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
        'number' => 'required|numeric',
      ]);

      $state_id = State::where('name','=','Creado')->first()->id;

      // si pasa la validacion creo el expte
      try {

        DB::beginTransaction();

          $expedient = Expedient::create([
            'number' => $request->input('number'),
            'title' => $request->input('title'),
            'year_id' => $request->input('year_id'),
            'type_id' => $request->input('type_id'),
            'user_create_id' => Auth::user()->id,
            'user_owner_id' => $request->user_owner_id,
            'state_id' => $state_id,
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
      $typeFiles = TypeFile::pluck('name','id');
      return view('expedients.show')
        ->withExpedient($expedient)
        ->withtypeFiles($typeFiles);

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

      Expedient::delete($id);

      Flash::success('expediente eliminado correctamente');
      return redirect()->back();
    }

    /**
     ** Muestro el expte en cuestion para el Pase
     */
    public function pass($id)
    {
      $expedient = Expedient::find($id);
      // traigo los pases que no se recibieron aun
      $expte = $expedient->passes()->whereReceivedAt(null)->get();

      // si hay pases sin recibir
      if ($expte->count()) {
        Flash::warning('El expediente no fue recibido en una instancia anterior');
        return redirect()->back();
      }else {
        $users = User::whereNotIn('id',[1])->pluck('display_name','id');
        return view('expedients.pass',compact('expedient','users'));
      }
    }

    /**
     ** Guardo el Pase en la DB
     */
    public function passConfirmed($id)
    {
      Pass::create([
        'expedient_id' => $id,
        'user_receiver_id' => request()->get('user_id'),
        'user_sender_id' => Auth::user()->id,
        'observation' => request()->get('observ')
      ]);
      return redirect()->route('expedients.index');
    }

    /**
     * Reingreso del expediente
     * Muestro en pantalla todos los expedientes que le dieron salida
     */
     public function ingress()
     {
         $expedients = Expedient::whereStateId(3)->get();
         return view('expedients.ingress')->withExpedients($expedients);
     }

     /**
      * Confirmo el reingreso del expediente
      * Muestro en pantalla los datos del expte en cuestion y una Observación
      */
     public function ingressConfirmed($id)
     {
       $expedient = Expedient::find($id);
       return view('expedients.ingressConfirmed')
                        ->withExpedient($expedient);
     }

     /**
      * Guardo el reingreso del expediente en DB
      */
     public function ingressConfirmedTrue($id)
     {
       $state_id = State::where('name','=','Ingreso')->first()->id;
       $expedient = Expedient::find($id);
       $expedient->state_id = $state_id;
       $expedient->save();

       //guardo el movimiento y la observacion
       Movement::create([
         'observation' => request()->get('observ'),
         'action' => 'Ingreso de expediente',
         'expedient_id' => $id,
         'user_id' => Auth()->user()->id,
       ]);
       //genero el pase
       return redirect()->route('expedients.index');
     }

    /**
     * Salida del expediente
     */
     public function egress($id)
     {
       $expedient = Expedient::find($id);
       $expedient->state_id = 3;
       $expedient->save();

       //guardo el movimiento y la observacion
       Movement::create([
         'action' => 'Salida de expediente',
         'expedient_id' => $id,
         'user_id' => Auth()->user()->id,
       ]);

       Flash::success('Expediente egresado satisfactoriamente');
       return redirect()->back();
     }

    public function receive($id)
    {
      $expedient = Expedient::find($id);
      $pass = $expedient->passes()->whereReceivedAt(null)->first();
      $pass->received_at = date('Y-m-d H:i:s');
      $pass->save();

      return redirect()->back();
    }

    /**
     ** retorno la vista para que le agregue una observacion al rechazo del pase
     */
    public function rechazar($id)
    {
      $expedient = Expedient::find($id);
      return view('expedients.rechazar',compact('expedient'));
    }

    /**
     ** Guardo el rechazo del pase y devuelvo
     */
    public function rechazado($id)
    {
      $expedient = Expedient::find($id);
      $pass = $expedient->passes()->whereReceivedAt(null)->first();
      $pass->received_at = date('Y-m-d H:i:s');
      $pass->save();

      Pass::create([
        'expedient_id' => $id,
        'user_receiver_id' => $pass->user_sender_id,
        'user_sender_id' => Auth::user()->id,
        'observation' => request()->get('observation'),
      ]);

      return redirect()->back();
    }

    public function addFile(Request $request,$id)
    {
      request()->validate([
        'title_file' => 'required|string',
        'file' => 'required|mimes:pdf,doc,docx,odt',
      ]);

      //obtenemos el campo file definido en el formulario
       $file = $request->file('file');

       /**
        *  Obtengo los datos del archivo
        */

       //nombre
       $nombre = $file->getClientOriginalName();
       //extension
       $extension = $file->getClientOriginalExtension();
       //destino
       $destination = public_path().'/files/'.$id.'/';

       // no existe el destino?
       if (!file_exists($destination)) {
         //creo carpeta destino
          mkdir($destination, 0777, true);
        }

      // $files_name = $nombre;
       $file->move($destination,$nombre);

        //creo un Documento
        $file = new File();
        $file->title = $request->title_file;
        $file->name = $nombre;
        $file->url = $destination;
        $file->extension= $extension;
        $file->expedient_id = $id;
        $file->type_id = $request->typeFile_id;
        $file->user_id = Auth::user()->id;
        $file->save();

        return redirect()->back();
    }

    public function download($id,$files_id)
    {
      $file = File::find($files_id);
      $name = $file->name;

      $file= public_path(). '/files/'.$id.'/'.$file->name;
      $headers = array(
                'Content-Type: application/pdf',
              );

      return response()->download($file, $name, $headers);
    }

    public function destroyFile($expedient_id,$file_id)
    {
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
