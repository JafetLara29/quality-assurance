<?php

namespace App\Http\Controllers;

use App\Models\Criterion;
use App\Http\Requests\StoreCriterionRequest;
use App\Http\Requests\UpdateCriterionRequest;
use App\Mail\ReviewFunctionalityMail;
use App\Models\Functionality;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
         // Obtenemos la lista de usuarios para hacer asignar responsable
         $users = User::all();
         
        return view('criteria.index')->with([
            'functionality'=>$functionality,
            'users' => $users,
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
        $criterion->users()->attach($request->user_id);
        // Informamos a los devs encargados:
        if(($request->state) == 'Defectuoso'){
            foreach($criterion->users as $user){
                if($user->type == 'Developer'){
                    Mail::to($user->email)->send(new ReviewFunctionalityMail($user, Auth::user(), $functionality, "Criterion"));    
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
        if(($request->state) == 'Revisar'){
            foreach($criterion->users as $user){
                if($user->type == 'QA'){
                    Mail::to($user->email)->send(new ReviewFunctionalityMail($user, Auth::user(), $criterion, "Criterion"));    
                }
            }
        }else{
            if(($request->state) == 'Defectuoso'){
                foreach($criterion->users as $user){
                    if($user->type == 'Developer'){
                        Mail::to($user->email)->send(new ReviewFunctionalityMail($user, Auth::user(), $criterion, "Criterion"));    
                    }
                }
            }
        }
        $criterion->update($request->validated());
        $criterion->users()->detach();
        $criterion->users()->attach($request->user_id);

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
        $criterion->users()->detach();
        $attachments = $criterion->attachments;
        foreach($attachments as $attachment){
            $attachment->delete();
        }
        $criterion->delete();
        return Response::json(array(
            'message'=> 'success',
        ));
    }
}
