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

$factory->define(\Eportal\Models\User\User::class, function (Faker $faker) {
    $gender = rand(0, 1);
    if($gender){
        $gender = \Eportal\Models\User\User::USER_MALE;
        $firstName = $faker->firstNameMale;
    }else{
        $gender = \Eportal\Models\User\User::USER_FEMALE;
        $firstName = $faker->firstNameFemale;
    }
    return [
        'first_name' => $firstName,
        'last_name' => $faker->lastName,
        'middle_name' => $faker->name,
        'username' => $faker->unique()->userName,
        'dob' => $faker->date(),
        'gender' => $gender,
        'password' => $faker->password, // secret
        'remember_token' => str_random(10),

    ];
});
