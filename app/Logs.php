<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $table = 'logs';

    protected $fillable = [
        'id_alumno','id_user','action'
    ];


    public function user(){
        return $this->hasMany(Logs::class,'id_user');
    }

    public function alumno(){
        return $this->belongsTo(Alumnos::class,'id_alumno');
    }
    
}
