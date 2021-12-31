<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

use App\Entity;
use App\Purchase;
use App\Sale;

$factory->define(Product::class, function (Faker $faker) {
    $random_status = $faker->randomElement(["Disponible", "Vendido", "Pendiente"]);

    $purchase_id = null;
    $sale_id     = null;
    if ( $random_status === "Disponible" || $random_status === "Pendiente" ) {
        $purchase_id = Purchase::pluck('id')[$faker->numberBetween(1,Purchase::count()-1)];
    } elseif ( $random_status === "Vendido" ) {
        $purchase_id = Purchase::pluck('id')[$faker->numberBetween(1,Purchase::count()-1)];
        $sale_id     = Sale::pluck('id')[$faker->numberBetween(1,Sale::count()-1)];
    }

    return [
        "single_cost_when_bought" => rand(500,1000),
        "suggested_price"         => rand(3000,4000),
        "suggested_profit"        => rand(1000,2000),
        "final_sale_price"        => rand(3000,5000),
        "final_profit_on_sale"    => rand(1000,3000),
        "status"                  => $faker->randomElement(["Disponible", "Vendido", "Pendiente"]),
        "entity_id"               => Entity::pluck('id')[$faker->numberBetween(1,Entity::count()-1)],
        "purchase_id"             => $purchase_id,
        "sale_id"                 => $sale_id,
        "created_at"              => $faker->dateTimeBetween($startDate='-10 years', $endDate='now', $timezone=null),
    ];
});
