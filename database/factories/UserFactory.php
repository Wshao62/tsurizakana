<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'name' => $faker->name,
        'password' => '$2y$10$Fn8PAyd60P1hY3aeTvmzBeKYQ1N0PsIZVg4QofQ0JMAo/Kjg3tAWy', // password123
        'furigana' => $faker->kanaName,
        'zipcode' => $faker->postcode,
        'prefecture' => $faker->prefecture,
        'public_address' => $faker->city. $faker->streetAddress,
        'private_address' => $faker->city. $faker->streetAddress,
        'mobile_tel' => $faker->phoneNumber,
        'tel' => $faker->phoneNumber,
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'name' => $faker->name,
        'password' => '$2y$10$Fn8PAyd60P1hY3aeTvmzBeKYQ1N0PsIZVg4QofQ0JMAo/Kjg3tAWy', // password123
        'furigana' => $faker->kanaName,
        'zipcode' => $faker->postcode,
        'prefecture' => $faker->prefecture,
        'public_address' => $faker->city. $faker->streetAddress,
        'private_address' => $faker->city. $faker->streetAddress,
        'mobile_tel' => $faker->phoneNumber,
        'tel' => $faker->phoneNumber,
        'remember_token' => str_random(10),
        'deleted_at' => date('2018-10-01 00:00:00'),
    ];
}, 'deleted');
