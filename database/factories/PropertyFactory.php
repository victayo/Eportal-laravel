<?php
/**
 * Created by victokala.
 * Date: 3/12/2018
 * Time: 4:40 PM
 */

$factory->define(\Eportal\Models\Property::class, function (\Faker\Generator $faker){
    return [
        'name' => $faker->words(5, true)
    ];
});