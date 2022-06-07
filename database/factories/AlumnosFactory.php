<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Alumnos;
use Faker\Generator as Faker;

$factory->define(Alumnos::class, function (Faker $faker) {
    return [
        'code' => $faker->md5,
        'name' => $faker->name,
        'surname' => $faker->lastname,
        'birthDate' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'authorized' => 0,
    ];
});
