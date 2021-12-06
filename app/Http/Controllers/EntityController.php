<?php

namespace App\Http\Controllers;

use App\Entity;
use Illuminate\Http\Request;

use App\Product;

class EntityController extends Controller
{
    public function index( Request $request )
    {
        $product_relations = ['purchase', 'entity', 'values', 'values.attribute'];

        $products = Product::where('entity_id', $request->get('entity_id'))->where('status', 'Disponible')->with( $product_relations )->get();

        $entity_relations = ['products', 'attributes', 'attributes.values'];
        $entity   = Entity::where('id', $request->get('entity_id') )->with( $entity_relations )->first();
        
        return view('entities.index', [
            'products' => $products,
            'entity'   => $entity,
            'productos' => $products->toJson(),
            'atributos' => $entity->attributes->toJson(),
        ]);
    }

    public function get_available_products_by_entity_name( Request $request )
    {
        $entity_name = $request->get('entity_name');

        $relations = [
            'values', 'entity', 'values.attribute', 'purchase'
        ];
        $available_products = Product::where('status', 'Disponible')
                                        ->with( $relations )
                                        ->whereHas('entity', function($q) use ($entity_name) {
                                            $q->where('name', $entity_name);
                                        })
                                        ->get();
        $attributes = [];
        foreach ($available_products as $product) {
            foreach ($product->values as $value) {
                if ( $value ) {
                    if ( !array_key_exists($value->attribute->name, $attributes) ) {
                        $attributes[$value->attribute->name] = [];
                    } else {
                        if ( !in_array( $value->name, $attributes[$value->attribute->name] ) ) {
                            array_push( $attributes[$value->attribute->name], $value->name );
                        }
                    }
                }
            }
        }
        return response()->json([
            'available_products' => $available_products,
            'attributes'         => $attributes,
        ]);
    }
}
