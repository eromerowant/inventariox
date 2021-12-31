<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Purchase;
use Faker\Generator as Faker;

$factory->define(Purchase::class, function (Faker $faker) {
    return [
        "final_amount" => rand(10000,20000),
        "status"       => $faker->randomElement(["Pendiente", "Recibida"]),
        "created_at"   => $faker->dateTimeBetween($startDate='-10 years', $endDate='now', $timezone=null),
    ];
});
