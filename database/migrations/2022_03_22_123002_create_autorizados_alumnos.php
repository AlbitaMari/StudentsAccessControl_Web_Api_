<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutorizadosAlumnos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autorizados_alumnos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_alumno')->nullable();
            $table->foreign('id_alumno')->references('id')->on('alumnos')->onDelete("cascade");
            $table->unsignedBigInteger('id_autorizado')->nullable();
            $table->foreign('id_autorizado')->references('id')->on('autorizados')->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autorizados_alumnos');
    }
}
