<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(App\Project::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'owner_id' => function() {
            return factory(User::class)->create()->id;
        }
    ];
});
