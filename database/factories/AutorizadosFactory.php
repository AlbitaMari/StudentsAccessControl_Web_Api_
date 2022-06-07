<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Autorizados;
use Faker\Generator as Faker;

$factory->define(Autorizados::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'surname' => $faker->lastname,
        'dni' => $faker->md5,
    ];
});
