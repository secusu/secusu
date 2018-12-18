<?php

use App\Models\Secu;
use Faker\Generator as Faker;

$factory->define(Secu::class, function (Faker $faker) {
    return [
        'data' => $faker->paragraph(),
    ];
});
