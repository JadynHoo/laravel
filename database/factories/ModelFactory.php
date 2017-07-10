<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Http\Model\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Http\Model\Link::class, function (Faker\Generator $faker) {
    return [
        'link_name' =>$faker->name,
        'link_title' =>$faker->name,
        'link_url' => $faker->url,
        'link_order'=>$faker->numberBetween(1,100),

    ];
});

$factory->define(App\Http\Model\Nav::class, function (Faker\Generator $faker) {
    return [
        'nav_name' =>$faker->name,
        'nav_alias' =>$faker->name,
        'nav_url' => $faker->url,
        'nav_order'=>$faker->numberBetween(1,100),

    ];
});

$factory->define(App\Http\Model\Config::class, function (Faker\Generator $faker) {
    return [
        'conf_name' =>$faker->name,
        'config_title' =>$faker->name,
        'config_content' => $faker->sentences,
        'config_order'=>$faker->numberBetween(1,100),
        'conf_tips' => $faker->name,
        'field_type' => $faker->name,
        'field_value' => $faker->name,
    ];
});