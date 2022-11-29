<?php

namespace App\Http\Controllers;

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
        // Contadores de "Revisar"
        $functionalitiesRevCount = $functionalities->where('state', 'Revisar')->count();
        $criterionRevCount = $criterion->where('state', 'Revisar')->count();
        // Funcionalidades y criterios para revisar
        $functionalitiesRev = $functionalities->where('state', 'Revisar');
        $criterionRev = $criterion->where('state', 'Revisar');
        // dd($functionalitiesRev);
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

    public function changeFunctionalityState(Functionality $functionality)
    {
        // if(($functionality->state) == 'Revisar'){
        //     foreach($functionality->users as $user){
        //         Mail::to($user->email)->send(new ReviewFunctionalityMail($user, Auth::user(), $functionality, "Functionality"));    
        //     }
        // }
        $updated = Functionality::find($functionality->id);
        $updated->state = 'Correcto';
        $updated->save();
        return $this->index();
    }
    public function changeCriterionState(Criterion $criterion)
    {
        // if(($functionality->state) == 'Revisar'){
        //     foreach($functionality->users as $user){
        //         Mail::to($user->email)->send(new ReviewFunctionalityMail($user, Auth::user(), $functionality, "Functionality"));    
        //     }
        // }
        $updated = Criterion::find($criterion->id);
        $updated->state = 'Correcto';
        $updated->save();
        return $this->index();
    }
}
