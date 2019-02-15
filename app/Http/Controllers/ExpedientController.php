<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use Illuminate\Http\Response;
use Carbon\Carbon;
use App\Expedient;
use App\File;
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
          $expedients = Expedient::paginate(7);
          return view('expedients.index')
                        ->withExpedients($expedients);
        }else {
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

      if (!Auth::user()->can('expedient_create')) {
        abort(403, 'No tiene permisos para crear expedientes....');
      }

        $years = Year::pluck('number','id');
        $types = Type::pluck('name','id');
        $selected = Carbon::now()->format('Y');
        return view('expedients.create')
                        ->withYears($years)
                        ->withTypes($types)
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
          'number' => ['numeric','required'],
          'title' => ['required','string','min:10'],
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
            'user_owner_id' => $request->user_id
          ]);

          Pass::create([
            'expedient_id' => $expedient->id,
            'user_receiver_id' => $request->user_id,
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
        return $id;
    }

    public function addFile(Request $request,$id){

      //obtenemos el campo file definido en el formulario
       $file = $request->file('file');

       //obtenemos el nombre del archivo
       $nombre = $file->getClientOriginalName();
       $extension = $file->getClientOriginalExtension();
       $destination = public_path().'/files/'.$id.'/';
       $files_name = $nombre;
       $file->move($destination,$files_name);

        //creo un Documento
        $file = new File();
        $file->title = $request->title_file;
        $file->name = $files_name;
        $file->url = $destination;
        $file->expedient_id = $id;
        $file->user_id = Auth::user()->id;
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
}
