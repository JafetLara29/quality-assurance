<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criterion extends Model
{
    use HasFactory;
    protected $fillable = [
        'scenary',
        'description',
        'state',
        // 'user_id',
    ];

    protected $appends = ['user'];//user: encargado

    public function users(){//Una criterio pertenece a uno o varios usuarios
        return $this->belongsToMany(User::class);
    }

    public function functionality(){
        return $this->belongsTo(Functionality::class);
    }
    public function attachments(){
        return $this->hasMany(attachment::class);
    }

    public function getUserAttribute(){//Obtener encargado, lo debemos hacer así porque en js no podemos llamar al objeto user y utilizarlo
        return $this->users()->get();
    }
}
