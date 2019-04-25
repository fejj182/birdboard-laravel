<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(App\Project::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'description' => $faker->sentence(4),
        'owner_id' => function() {
            return factory(User::class)->create()->id;
        }
    ];
});
