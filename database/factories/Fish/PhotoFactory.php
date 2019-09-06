<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Fish\Photo::class, function (Faker $faker) {
    return [
        'fish_id' => 1,
        'file_name' => $faker->imageUrl($faker->numberBetween(480, 640), $faker->numberBetween(480, 640)),
        'order' => 1,
    ];
});
