<?php

use Faker\Generator as Faker;
use App\Project;
use App\Task;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'description' => $faker->sentence(4),
        'project_id' => function() {
            return factory(Project::class)->create()->id;
        }
    ];
});
