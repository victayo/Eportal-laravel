<?php

use Faker\Generator as Faker;

$factory->define(\Eportal\Models\School::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word
    ];
});
