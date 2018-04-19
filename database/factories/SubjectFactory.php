<?php

use Faker\Generator as Faker;

$factory->define(Eportal\Models\Subject::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word.'_subject'
    ];
});
