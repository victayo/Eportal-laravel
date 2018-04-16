<?php

use Faker\Generator as Faker;

$factory->define(\Eportal\Models\PropertyValue::class, function (Faker $faker) {
    $properties = \Eportal\Models\Property::pluck('id')->toArray();
    return [
        'name' => $faker->unique()->word,
        'property_id' => $faker->randomElement($properties)
    ];
});
