<?php

use Faker\Generator as Faker;

$factory->define(App\Models\LinkedSocialAccount::class, function (Faker $faker) {
    return [
        'temp_regist_email' => null,
        'user_id' => $faker->bothify('######'),
        'provider_name' => 'facebook',
        'provider_id' => $faker->bothify('************'),
    ];
});

$factory->define(App\Models\LinkedSocialAccount::class, function (Faker $faker) {
    return [
        'temp_regist_email' => $faker->unique()->safeEmail,
        'user_id' => null,
        'provider_name' => 'facebook',
        'provider_id' => $faker->bothify('************'),
    ];
}, '仮登録');
