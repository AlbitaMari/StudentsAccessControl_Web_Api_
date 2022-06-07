<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Logs;
use Faker\Generator as Faker;

$factory->define(Logs::class, function (Faker $faker) {
    return [
        'id_alumno'=> \App\Alumnos::all()->random()->id,
        'id_user' => \App\User::all()->random()->id,
        'action' => $faker->word,
    ];
});
