<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\isNull;

class Functionality extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'state',
        // 'user_id',
    ];
    protected $appends = ['percent', 'user'];//user: encargado

    //Una funcionalidad pertenece a un modulo
    public function module(){
        return $this->belongsTo(Module::class);
    }

    public function criteria(){
        return $this->hasMany(Criterion::class);
    }

    public function users(){//Una funcionalidad pertenece a uno o varios usuarios
        return $this->belongsToMany(User::class);
    }

    public function getPercentAttribute(){
        // Obtenemos el numero de criterios de esta funcionalidad
        $criteria = $this->criteria;
        $totalCriteria = $criteria->count();
        // Si no hay criterios registrados:
        if($totalCriteria == null || $totalCriteria == 0){
            //Nos aseguramos que numero de criterios sea cero y no null. Despues seteamos el porcentaje en cero
            $totalCriteria = 0;
            $percent = 0;
        }else{
            // Contamos la cantidad de esos modulos que contienen estado = "Correcto"
            $correctCriteria =  $criteria->where('state', 'Correcto');
            // dd($criteria);
            if($correctCriteria->count() == 0 || $correctCriteria->count() == null){//Si no hay ningun criterio exitoso:
                $percent = 0;//El porcentaje de exito de la funcionalidad es cero
            }else{//Si hay algun criterio exitoso:
                $percent = $correctCriteria->count()/$totalCriteria*100;//determinamos el porcentaje de exito de la funcionalidad
            }
        }
        
        return round($percent, 2);
    }

    public function getUserAttribute(){//Obtener encargado, lo debemos hacer así porque en js no podemos llamar al objeto user y utilizarlo
        return $this->users()->get();
    }
}
