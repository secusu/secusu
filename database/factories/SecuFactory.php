<?php

declare(strict_types=1);

use App\Models\Secu;
use Faker\Generator as Faker;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Secu::class, function (Faker $faker) {
    return [
        'data' => $faker->paragraph(),
    ];
});
