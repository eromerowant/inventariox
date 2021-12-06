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
}
