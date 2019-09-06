<?php

use Faker\Generator as Faker;

$factory->define(App\Models\TempRegist::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'token' => $faker->unique()->bothify('****************************************'),
    ];
});
