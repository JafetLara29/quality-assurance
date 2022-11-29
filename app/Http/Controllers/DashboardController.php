<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        // Obtenemos el numero de funcionalidades asociadas
        $user = User::find(Auth::user()->id);
        // Extraccion de los datos
        $modules = $user->modules()->where('user_id', $user->id);
        $functionalities = $user->functionalities()->where('user_id', $user->id);
        $criterion = $user->criteria()->where('user_id', $user->id);
        // Contadores
        $modulesCount = $modules->count();
        $functionalitiesCount = $functionalities->count();
        $criterionCount = $criterion->count();
        // Contadores de "Revisar"
        $functionalitiesRev = $functionalities->where('state', 'Revisar')->count();
        $criterionRev = $criterion->where('state', 'Revisar')->count();
        return view('dashboards.index')->with([
            'modules'=>$modulesCount,
            'functionalities'=>$functionalitiesCount,
            'criterion'=>$criterionCount,
            'functionalitiesRev'=>$functionalitiesRev,
            'criterionRev'=>$criterionRev,
        ]);
    }
}
