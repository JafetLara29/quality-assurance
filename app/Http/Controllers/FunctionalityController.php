<?php

namespace App\Http\Controllers;

use App\Models\Functionality;
use App\Http\Requests\StoreFunctionalityRequest;
use App\Http\Requests\UpdateFunctionalityRequest;
use App\Models\Module;
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
        return view('functionalities.index')->with([
            'module'=>$module
        ]);
    }

    public function all(){
        //Obtenemos el modulo por medio del id buscado
        $module = Module::findOrFail($_POST['moduleId']); 
        //Obtenemos las funcionalidades de este modulo
        $functionalities = $module->functionalities;
        // $functionality = $functionalities->get(1);
        // $criteria = $functionality->criteria;
        // dd($criteria);
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
        $functionality->update($request->validated());
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
        $functionality->delete();
        return Response::json(array(
            'message'=> 'success',
        ));
    }
}
