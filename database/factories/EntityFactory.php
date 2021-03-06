<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entity;
use Faker\Generator as Faker;

$factory->define(Entity::class, function (Faker $faker) {
    return [
        "name" => $faker->unique()->word,
    ];
});
