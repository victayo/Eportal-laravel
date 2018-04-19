<?php

use Faker\Generator as Faker;

$factory->define(Eportal\Models\Session::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word.'_session'
    ];
});
