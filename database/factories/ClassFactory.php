<?php

use Faker\Generator as Faker;

$factory->define(Eportal\Models\EportalClass::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word
    ];
});
