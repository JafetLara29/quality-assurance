<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    protected $fillable = [
        'module',
    ];
    protected $appends = ['user'];//user: encargado

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function functionalities(){
        return $this->hasMany(Functionality::class);
    }

    public function getUserAttribute(){
        return $this->users()->get();
    }
}
