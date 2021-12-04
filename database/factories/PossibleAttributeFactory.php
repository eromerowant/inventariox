<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PossibleAttribute;
use Faker\Generator as Faker;

use App\PossibleEntity;

$factory->define(PossibleAttribute::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['Tamaño', 'Color', 'Marca']),
        'possible_entity_id' => PossibleEntity::pluck('id')[$faker->numberBetween(1,PossibleEntity::count()-1)],
    ];
});
