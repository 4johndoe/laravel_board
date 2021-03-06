<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entity\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(User::class, function (Faker $faker) {
    $isActive = rand(0, 1);
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'verify_token' => $isActive ? null : Str::uuid(),
        'role' => $isActive
            ? $faker->randomElement([User::ROLE_USER, User::ROLE_ADMIN])
            : User::ROLE_USER,
        'status' => $isActive ? User::STATUS_ACTIVE : User::STATUS_WAIT
    ];
});
