<?php

declare(strict_types=1);

use App\Models\Feedback;
use Faker\Generator;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Feedback::class, function (Generator $faker) {
    return [
        'email' => $faker->email,
        'body' => $faker->paragraph(),
    ];
});
