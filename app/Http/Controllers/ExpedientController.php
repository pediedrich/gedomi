<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
//use Illuminate\Support\Facades\Crypt;
use Laracasts\Flash\Flash;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Support\Collection as Collection;
use Auth;


use App\Expedient;
use App\File;
use App\TypeFile;
use App\Role;
use App\User;
use App\Type;
use App\Pass;
use App\State;
use App\Movement;
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
        if (Auth::user()->hasRole('ministro')) {
          return redirect()->route('expedients.assign.list');
        }
      // permisos
        if( Auth::user()->can('expedient_list')){
          // traigo los exptedientes que le fueron asignados
         $expedients = Expedient::whereUserOwnerId(Auth::user()->id)->whereNotIn('state_id',[3])->get();
          // traigo los exptes que le fueron pasados
          // $expedients = Expedient::join("pass","expedients.id","=","pass.expedient_id")
          //               ->where('pass.user_receiver_id','=',Auth::user()->id)
          //               ->get();

                        // dd($expedients[0]->passes()->get());

          //creo la variable $create para ocupar la misma vista en el caso de asignar y no mostrar el boton de crear exptes
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
      // Muestro los expedientes para dentro del sector y boton crear
        if( Auth::user()->can('expedient_create') || Auth::user()->hasRole('ministro')){
          //estado 3 = "Egreso" => expediente fuera de la dependencia
          $expedients = Expedient::WhereNotIn('state_id',[3])->get();
          return view('expedients.indexAssign')
                        ->withExpedients($expedients);
        }else {
          Flash::warning('no tiene permisos');
          return redirect()->back();
        }
    }

    public function indexSearch()
    {
      // Muestro los expedientes para dentro del sector y boton crear
      $expedients = Expedient::all();
      return view('expedients.indexSearch')
                      ->withExpedients($expedients);
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

      if ($request->user_owner_id == 0) {
        $owner = null;
      }else {
        $owner = $request->user_owner_id;
      }

      // si pasa la validacion creo el expte
      try {

        DB::beginTransaction();

          $expedient = Expedient::create([
            'number' => $request->input('number'),
            'title' => $request->input('title'),
            'year_id' => $request->input('year_id'),
            'type_id' => $request->input('type_id'),
            'user_create_id' => Auth::user()->id,
            'user_owner_id' => $owner,
            'state_id' => $state_id,
          ]);

          // si viene usuario genero el pase

            Pass::create([
              'expedient_id' => $expedient->id,
              'user_receiver_id' => $owner,
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
      if (!Auth::user()->can(['expedient_show','expedient_show_admin'])){
        abort(403);
      }
      //$id =  Crypt::decrypt($id);

      $expedient = Expedient::find($id);
      $typeFiles = TypeFile::pluck('name','id');

      // la consutla es si es relator que pueda ver solo los Administrativos (esto es en caso de que quiera setear datos en la url)
      if (Auth::user()->hasRole(['coordinador','coordinador_superior'])) {
        //if ($expedient->type()->first()->name === 'Administrativo') {
          return view('expedients.show')
                      ->withExpedient($expedient)
                      ->withtypeFiles($typeFiles);
        // }
        // else {
        //   flash::error('El Expediente al que intenta ingresar no es Administrativo.-');
        //   return redirect('expedients');
        // }
      }
      else {
        if ($expedient->type()->first()->name != 'Administrativo') {
            return view('expedients.show')
                      ->withExpedient($expedient)
                      ->withtypeFiles($typeFiles);
        }
        else {
          flash::error('El Expediente al que intenta ingresar es Administrativo, no tiene permisos.-');
          return redirect('expedients');
        }
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function readOnly($id)
    {
      //$id =  Crypt::decrypt($id);

      $expedient = Expedient::find($id);
      $c = 1;
      return view('expedients.readOnly',compact('expedient','c'));
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
      // consulto si no tiene un pase sin recibir.
      $expedient = Expedient::find($id);
      $expedient->user_owner_id = request()->get('user_id');
      $expedient->save();

      Pass::create([
        'expedient_id' => $id,
        'user_receiver_id' => request()->get('user_id'),
        'user_sender_id' => Auth::user()->id,
        'observation' => request()->get('observ')
      ]);
      return redirect()->route('expedients.index');
    }


    public function reassignPass($id)
    {
      $expedient = Expedient::find($id);
      $users = User::whereNotIn('id',[1])->pluck('display_name','id');
      return view('expedients.reassign',compact('expedient','users'));
    }

    /**
     ** Guardo el Pase en la DB
     */
    public function reassignConfirmed($id)
    {
      // consulto si no tiene un pase sin recibir.
      $expedient = Expedient::find($id);
      $pass = $expedient->passes()->whereReceivedAt(null)->first();

      //si hay pases sin recibir, quiere decir que el usuario original nunca acepto el pase, y el coordinador esta reasignando
      if ($pass) {
        $userOwnerOld = $pass->first()->userReceiver()->first()->display_name;
        // se pone al relator como receptor del pase sin recibir y se observa
        $pass->received_at = date('Y-m-d H:i:s');
        $pass->user_receiver_id = Auth::user()->id;
        $pass->observation =  'El usuario '.Auth::user()->display_name.' recibe el expte para poder reasignar';
        $pass->update();

        $expedient->user_owner_id = request()->get('user_id');
        $expedient->update();
        //dd($pass);
      }
      // se crea el nuevo pase
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
      * Reingreso del expediente
      * Muestro en pantalla todos los expedientes que le dieron salida
      */
      public function egress($id)
      {
          $expedient = Expedient::findOrFail($id);
          return view('expedients.egress')->withExpedient($expedient);
      }

    /**
     * Salida del expediente
     */
     public function egressConfirmed($id)
     {

       // validaciones
       request()->validate([
         'observation' => 'required|min:10',
       ]);

       $expedient = Expedient::find($id);
       $expedient->state_id = 3;
       $expedient->update();

       //guardo el movimiento y la observacion
       Movement::create([
         'action' => 'Salida de expediente',
         'expedient_id' => $id,
         'observation' => request()->get('observation'),
         'user_id' => Auth()->user()->id,
       ]);

       Flash::success('Expediente egresado satisfactoriamente');
       return redirect()->route('expedients.index');
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
      request()->validate([
        'observation' => 'required|string',
      ]);

      // ANALIZAR LA SITUACION EN ESTE CASO.-
      $expedient = Expedient::find($id);

      //obtengo pase sin recibir
      $pass = $expedient->passes()->whereReceivedAt(null)->first();
      $pass->received_at = date('Y-m-d H:i:s');
      $pass->observation = 'pase rechazado';
      $pass->save();

      //cambio de owner para que el expte aparezca en la bandeja del ultimo que envio
      $expedient->user_owner_id = $pass->user_sender_id;
      $expedient->update();

      // genero el nuevo pase
      Pass::create([
        'expedient_id' => $id,
        'user_receiver_id' => $pass->user_sender_id,
        'user_sender_id' => Auth::user()->id,
        'observation' => request()->get('observation'),
      ]);

      return redirect('expedients');
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
