<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Blog::class, function (Faker $faker) {

    $text = $faker->realText;
    return [
      'title' => $faker->realText(20),
      'user_id' => 1,
      'plane_description' => $text,
      'description' => $text,
      'status' => 0,
    ];
});

$factory->define(App\Models\Blog\Photo::class, function (Faker $faker) {
    return [
        'blog_id' => 1,
        'file_name' => $faker->imageUrl($faker->numberBetween(480, 640), $faker->numberBetween(480, 640)),
        'order' => 1,
    ];
});
