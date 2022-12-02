<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCriterionStateRequest;
use App\Http\Requests\UpdateFunctionalityStateRequest;
use App\Mail\ReviewFunctionalityMail;
use App\Models\Criterion;
use App\Models\Functionality;
use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    public function index(){
        $user = User::find(Auth::user()->id);
        // Obtenemos el numero de modulos, funcionalidades y criterios asociados al usuario
        $modules = $user->modules;
        $functionalities = $user->functionalities;
        $criterion = $user->criteria;
        // Contadores
        $modulesCount = $modules->count();
        $functionalitiesCount = $functionalities->count();
        $criterionCount = $criterion->count();
        // Contadores de "Revisar". Si es un usuario QA el que está logeado deben mostrarse las que tienen estado revisar. Si es un usuario dev el que está logeado deben mostrarse las que tienen estado defectuoso.
        if($user->type == 'QA'){
            $functionalitiesRevCount = $functionalities->where('state', 'Revisar')->count();
            $criterionRevCount = $criterion->where('state', 'Revisar')->count();
            // Funcionalidades y criterios para revisar
            $functionalitiesRev = $functionalities->where('state', 'Revisar');
            $criterionRev = $criterion->where('state', 'Revisar');
        }else{
            $functionalitiesRevCount = $functionalities->where('state', 'Defectuoso')->count();
            $criterionRevCount = $criterion->where('state', 'Defectuoso')->count();
            // Funcionalidades y criterios para revisar
            $functionalitiesRev = $functionalities->where('state', 'Defectuoso');
            $criterionRev = $criterion->where('state', 'Defectuoso');
        }

        return view('dashboards.index')->with([
            'modulesCount'=>$modulesCount,
            'functionalitiesCount'=>$functionalitiesCount,
            'criterionCount'=>$criterionCount,
            'functionalitiesRevCount'=>$functionalitiesRevCount,
            'criterionRevCount'=>$criterionRevCount,
            'functionalitiesRev'=>$functionalitiesRev,
            'criterionRev'=>$criterionRev,
        ]);
    }

    public function changeFunctionalityState(UpdateFunctionalityStateRequest $request, Functionality $functionality)
    {
        // Guardamos el nuevo state de la funcionalidad
        $functionality->update($request->validated());
        // Una vez guardado, notificamos a los que corresponda dependiendo del estado
        if($request->state == 'Revisar'){
            foreach($functionality->users as $user){
                if($user->type == 'QA'){
                    Mail::to($user->email)->send(new ReviewFunctionalityMail($user, Auth::user(), $functionality, "Functionality"));    
                }
            }
        }else{
            if($request->state == 'Defectuoso'){
                foreach($functionality->users as $user){
                    if($user->type == 'Developer'){
                        Mail::to($user->email)->send(new ReviewFunctionalityMail($user, Auth::user(), $functionality, "Functionality"));    
                    }
                }
            }
        }
        return $this->index();
    }
    public function changeCriterionState(UpdateCriterionStateRequest $request, Criterion $criterion)
    {
        // Guardamos el nuevo state del criterio
        $criterion->update($request->validated());
        // Notificamos a los que corresponda, dependiendo del estado
        if($criterion->state == 'Revisar'){
            foreach($criterion->users as $user){
                if($user->type == 'QA'){
                    Mail::to($user->email)->send(new ReviewFunctionalityMail($user, Auth::user(), $criterion, "Criterion"));    
                }
            }
        }else{
            if($criterion->state == 'Defectuoso'){
                foreach($criterion->users as $user){
                    if($user->type == 'Developer'){
                        Mail::to($user->email)->send(new ReviewFunctionalityMail($user, Auth::user(), $criterion, "Criterion"));    
                    }
                }
            }   
        }
        return $this->index();
    }
}
