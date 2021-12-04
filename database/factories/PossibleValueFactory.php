<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PossibleValue;
use Faker\Generator as Faker;

use App\PossibleAttribute;

$factory->define(PossibleValue::class, function (Faker $faker) {
    $random = $faker->numberBetween(1,PossibleAttribute::count()-1);
    $attribute = PossibleAttribute::where('id', $random)->first();

    if ( $attribute->name === "Tamaño" ) {
        $values = ['Grande', 'Mediano', 'Pequeño'];
    } elseif ( $attribute->name === "Color" ) {
        $values = ['Amarillo', 'Verde', 'Blanco', 'Negro', 'Azul'];
    } elseif ( $attribute->name === "Marca" ) {
        $values = ['Apple', 'Samsung', 'Lenovo', 'Dell'];
    }

    return [
        'name' => $faker->randomElement( $values ),
        'possible_attribute_id' => $attribute->id,
    ];
});
