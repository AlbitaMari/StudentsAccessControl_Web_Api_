<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autorizados extends Model
{
    protected $table = 'autorizados';

    protected $fillable = [
        'name','surname','dni'
    ];

    public function autorizados(){
        return $this->belongsToMany(Alumnos::class,'autorizados_alumnos','id_autorizado','id_alumno');
    }
}
