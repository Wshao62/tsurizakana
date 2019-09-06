<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Fish\Category::class, function (Faker $faker) {
    $name = mb_substr($faker->realText, 0, rand(1, 30));
    return [
        'name' => $name,
    ];
});
