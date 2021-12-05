<?php

namespace App\Http\Controllers;

use App\Entity;
use Illuminate\Http\Request;

use App\Product;

class EntityController extends Controller
{
    public function index( Request $request )
    {
        $products = Product::where('entity_id', $request->get('entity_id'))->where('status', 'Disponible')->get();
        $entity = Entity::findOrFail( $request->get('entity_id') );

        return view('entities.index', [
            'products' => $products,
            'entity'   => $entity,
        ]);
    }
}
