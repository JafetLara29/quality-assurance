<?php

namespace App\Http\Controllers;

use App\Models\attachment;
use App\Http\Requests\StoreattachmentRequest;
use App\Http\Requests\UpdateattachmentRequest;
use App\Models\Criterion;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isEmpty;

class AttachmentController extends Controller
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
        //Obtenemos la funcionalidad por medio del id buscado
        $criterion = Criterion::findOrFail($_GET['id']); 
        $attachments = $criterion->attachments;
        
        return view('attachments.index')->with([
            'criterion' => $criterion,
            'attachments' => $attachments,
        ]);
    }

    // Alternative method for destroy and store method. It allow us to pass a id attribute instead a $_GET['id']
    public function index2($id)
    {
        //Obtenemos la funcionalidad por medio del id buscado
        $criterion = Criterion::findOrFail($id); 
        $attachments = $criterion->attachments;
        
        return view('attachments.index')->with([
            'criterion' => $criterion,
            'attachments' => $attachments,
        ]);
    }
    
    public function all(){
        //Obtenemos la funcionalidad por medio del id buscado
        $criterion = Criterion::findOrFail($_POST['functionalityId']); 
        //Obtenemos los adjuntos de esa funcionalidad
        $attachments = $criterion->attachments;
        // dd(asset($attachments->first()->image));
        return Response::json($attachments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreattachmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreattachmentRequest $request)
    {
        
        // Obtenemos la informacion enviada del formulario
        $requestData = $request->validated();

        // Creamos un nombre unico para el archivo
        $fileName = $request->file('image')->hashName();
        
        // Verificamos que tipo de archivo estamos guardando
        $fileType = $request->file('image')->getMimeType();

        // Verificamos el tipo de archivo
        if(str_contains($fileType, 'image') == true){
            $path = $request->file('image')->storeAs('images', $fileName, 'public');
        }else{
            $path = $request->file('image')->storeAs('documents', $fileName, 'public');
        }
        // Guardamos el path y el tipo de archivo en el modelo
        $requestData['image'] = '/storage/'.$path;// "/storage/images/nombreArchivo.extension"
        $requestData['type'] = $fileType;
        
        // Guardamos los datos en la base de datos
        $criterion = Criterion::find($_POST['criterionId']);
        $attachment = new attachment($requestData);
        $criterion->attachments()->save($attachment);

        return $this->index2($_POST['criterionId']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function show(attachment $attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function edit(attachment $attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateattachmentRequest  $request
     * @param  \App\Models\attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateattachmentRequest $request, attachment $attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(attachment $attachment)
    {
        $criterion = $attachment->criterion;
        File::delete(public_path($attachment->image));
        $attachment->delete();
        return $this->index2($criterion->id);

    }
}
