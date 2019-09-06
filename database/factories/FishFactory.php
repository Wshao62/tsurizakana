<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Fish::class, function (Faker $faker) {
    return [
        'fish_category_id' => 1,
        'fish_category_name' => mb_substr($faker->realText, 0, rand(1, 30)),
        'seller_id' => 1,
        'buyer_id' => 1,
        'location' => $faker->address,
        'destination' => $faker->address,
        'price' => rand(100, 10000),
        'description' => $faker->realText,
        'status' => App\Models\Fish::STATUS_PUBLISH,
        'deleted_at' => null,
    ];
});

$factory->define(App\Models\Fish::class, function (Faker $faker) {
    $cat = App\Models\Fish\Category::firstOrCreate(factory(App\Models\Fish\Category::class)->make()->toArray());
    $statement = DB::select("show table status like 'fish_photos'");
    $id = $statement[0]->Auto_increment;
    factory(App\Models\Fish\Photo::class)->create(['fish_id' => $id]);
    return [
        'fish_category_id' => $cat->id,
        'fish_category_name' => $cat->name,
        'seller_id' => 1,
        'buyer_id' => null,
        'location' => $faker->address,
        'destination' => $faker->address,
        'price' => rand(100, 10000),
        'description' => $faker->realText,
        'status' => App\Models\Fish::STATUS_PUBLISH,
        'deleted_at' => null,
    ];
}, 'create_all');
