<?php

use App\Models\Feedback;
use Faker\Generator;

$factory->define(Feedback::class, function (Generator $faker) {
    return [
        'email' => $faker->email,
        'body' => $faker->paragraph(),
    ];
});
