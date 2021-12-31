<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sale;
use Faker\Generator as Faker;

$factory->define(Sale::class, function (Faker $faker) {
    return [
        "final_amount" => rand(30000,50000),
        "final_cost"   => rand(10000,20000),
        "final_profit" => rand(20000,30000),
        "status"       => $faker->randomElement([null, "Finalizada"]),
        "created_at"   => $faker->dateTimeBetween($startDate='-10 years', $endDate='-1 years', $timezone=null),
    ];
});
