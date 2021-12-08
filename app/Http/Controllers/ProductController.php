<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function get_filtered_available_products( Request $request )
    {
        $relations = ['values', 'entity', 'values.attribute'];
        $peticion = Product::where('status', 'Disponible')
                            ->has('values')
                            ->with( $relations );
        // Entidad
        $entity_selected = $request->get('entity_selected');
        $peticion->whereHas('entity', function($q) use ($entity_selected){
            $q->where('name', $entity_selected);
        });

        // Atributos
        foreach ($request->get('combination') as $query_value) {
            $peticion->whereHas('values', function($q) use ($query_value){
                $q->where('name', $query_value);
            });
        }

        // Productos en cesta
        $product_ids = $request->get('product_ids');
        foreach ($product_ids as $product_id) {
            if ( $product_id ) {
                $peticion->where('id', '!=' , $product_id);
            }
        }

        $products = $peticion->get();
        return response()->json( $products );
    }
}
