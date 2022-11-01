<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    protected $fillable = [
        'module',
        'author',
    ];
    
    //Un modulo tiene muchas funcionalidades
    public function functionalities(){
        return $this->hasMany(Functionality::class);
    }
}
