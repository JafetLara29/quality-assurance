<?php

namespace App\Http\Controllers;

use App\Models\Criterion;
use App\Http\Requests\StoreCriterionRequest;
use App\Http\Requests\UpdateCriterionRequest;
use App\Models\Functionality;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CriterionController extends Controller
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
        $functionality = Functionality::findOrFail($_GET['id']); 
        return view('criteria.index')->with([
            'functionality'=>$functionality
        ]);
    }

    public function all(){
        //Obtenemos el modulo por medio del id buscado
        $functionality = Functionality::findOrFail($_POST['functionalityId']); 
        //Obtenemos las funcionalidades de este modulo
        $criteria = $functionality->criteria;
        
        return Response::json($criteria);
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
     * @param  \App\Http\Requests\StoreCriterionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCriterionRequest $request)
    {
        $functionality = Functionality::find($_POST['functionalityId']);
        $criterion = new Criterion($request->validated());
        $functionality->criteria()->save($criterion);
    
        return Response::json(array(   
            'message' => 'success',
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Criterion  $criterion
     * @return \Illuminate\Http\Response
     */
    public function show(Criterion $criterion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Criterion  $criterion
     * @return \Illuminate\Http\Response
     */
    public function edit(Criterion $criterion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCriterionRequest  $request
     * @param  \App\Models\Criterion  $criterion
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCriterionRequest $request, Criterion $criterion)
    {
        // dd($request->validated());
        $criterion->update($request->validated());
        return Response::json(array(
            'message' => 'success',
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Criterion  $criterion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Criterion $criterion)
    {
        $criterion->delete();
        return Response::json(array(
            'message'=> 'success',
        ));
    }
}
