<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Order::class, function (Faker $faker) {
    $user = factory(App\Models\User::class)->make();
    $fish = factory(App\Models\Fish::class)->make();
    return [
        'user_id' => 1,
        'user_name' => $user->name,
        'email' => $user->email,
        'item_id' => 1,
        'item_name' => $fish->fish_category_name,
        'price' => $fish->price,
        'trans_code' => null,
        'process_code' => 1,//新規でカード入力
        'completed_at' => null,
    ];
}, 'default');
