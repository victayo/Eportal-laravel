<?php

use Faker\Generator as Faker;

$factory->define(Eportal\Models\Department::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word.'_department'
    ];
});
