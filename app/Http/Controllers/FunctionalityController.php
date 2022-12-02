<?php

namespace App\Http\Controllers;

use App\Models\Functionality;
use App\Http\Requests\StoreFunctionalityRequest;
use App\Http\Requests\UpdateFunctionalityRequest;
use App\Mail\ReviewFunctionalityMail;
use App\Models\Module;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class FunctionalityController extends Controller
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
        //Obtenemos el modulo por medio del id buscado
        $module = Module::findOrFail($_GET['id']);
        // Obtenemos la lista de usuarios para hacer asignar responsable
        $users = User::all();
        return view('functionalities.index')->with([
            'module'=>$module,
            'users' => $users,
        ]);
    }
    
    public function all(){
        // $user = Auth::user();
        //Obtenemos el modulo por medio del id buscado
        $module = Module::findOrFail($_POST['moduleId']); 
        //Obtenemos las funcionalidades de este modulo
        $functionalities = $module->functionalities;//()->where('user_id', $user->id);
        
        // dd($functionalities[0]);
        return Response::json($functionalities);
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
     * @param  \App\Http\Requests\StoreFunctionalityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFunctionalityRequest $request)
    {
        $module = Module::find($_POST['moduleId']);
        $functionality = new Functionality($request->validated());
        $module->functionalities()->save($functionality);
        $functionality->users()->attach($request->user_id);
        // Informamos a los devs encargados:
        if(($request->state) == 'Defectuoso'){
            foreach($functionality->users as $user){
                if($user->type == 'Developer'){
                    Mail::to($user->email)->send(new ReviewFunctionalityMail($user, Auth::user(), $functionality, "Functionality"));    
                }
            }
        }
        return Response::json(array(   
            'message' => 'success',
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Functionality  $functionality
     * @return \Illuminate\Http\Response
     */
    public function show(Functionality $functionality)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Functionality  $functionality
     * @return \Illuminate\Http\Response
     */
    public function edit(Functionality $functionality)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFunctionalityRequest  $request
     * @param  \App\Models\Functionality  $functionality
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFunctionalityRequest $request, Functionality $functionality)
    {
        // Informamos a los encargados de QA
        if(($request->state) == 'Revisar'){
            foreach($functionality->users as $user){
                if($user->type == 'QA'){
                    Mail::to($user->email)->send(new ReviewFunctionalityMail($user, Auth::user(), $functionality, "Functionality"));    
                }
            }
        }else{
            if(($request->state) == 'Defectuoso'){
                foreach($functionality->users as $user){
                    if($user->type == 'Developer'){ 
                        Mail::to($user->email)->send(new ReviewFunctionalityMail($user, Auth::user(), $functionality, "Functionality"));    
                    }
                }
            }
        }
        $functionality->update($request->validated());
        $functionality->users()->detach();
        $functionality->users()->attach($request->user_id);
        return Response::json(array(
            'message' => 'success',
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Functionality  $functionality
     * @return \Illuminate\Http\Response
     */
    public function destroy(Functionality $functionality)
    {
        $functionality->users()->detach();//Desligamos a los usuarios de la funcionalidad
        $criteria = $functionality->criteria;//Extraemos los criterios ligados a la funcionalidad
        foreach($criteria as $criterion){
            $criterion->users()->detach();
            $criterion->attachments()->delete();
            $criterion->delete();
        }
        $functionality->delete();
        return Response::json(array(
            'message'=> 'success',
        ));
    }
}
