<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PossibleEntity;
use Faker\Generator as Faker;

$factory->define(PossibleEntity::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
