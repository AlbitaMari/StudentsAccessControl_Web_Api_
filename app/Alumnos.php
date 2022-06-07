<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumnos extends Model
{
    protected $table = 'alumnos';

    protected $fillable = [
        'id_user','code','name','surname','birthDate','authorized'
    ];

    public function logs(){
        return $this->hasMany(Logs::class,'id');
    }

    public function autorizados(){
        return $this->belongsToMany(Autorizados::class,'autorizados_alumnos','id_alumno','id_autorizado');
    }
}
