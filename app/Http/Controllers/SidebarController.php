<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use App\Ejemplare;
use App\Producto;
use App\Entidade;
use App\PossibleEntity;

use App\Product;
use App\Entity;

class SidebarController extends Controller
{
    public function configuracion()
    {
        return view('sidebar.configuracion');
    }

    public function comprasIndex()
    {
        $compras_en_camino = Purchase::where('status', "Pendiente")->with('products', 'products.entity')->get(); // Compras en camino
        $compras_recibidas = Purchase::where('status', "Recibida")->with('products', 'products.entity')->get(); // Compras recibidas

        return view('sidebar.compras.index', [
            'compras_en_camino' => $compras_en_camino,
            'compras_recibidas' => $compras_recibidas
        ]);
    }

    public function inventarioIndex()
    {

        // $productos_disponibles = Product::where('status', "Disponible")->get();
        $entities = Entity::with('products')->get();

        return view('sidebar.inventario.index', [
            'entities' => $entities,
        ]);
    }

    public function comprasCreate()
    {
        $columnas = ['id', 'name'];
        $relations = ['attributes', 'attributes.values'];
        $entidades = PossibleEntity::select( $columnas )->with( $relations )->get();
        return view('sidebar.compras.create', ['entidades' => $entidades]);
    }

    public function comprasShow($compra_id)
    {
        $compra = Purchase::with('products')->where('id', $compra_id)->first();

        return view('sidebar.compras.show', ['compra' => $compra]);
    }

    public function ventasIndex()
    {
        $ventas_pendientes = Purchase::where('status', 1)->get(); // ventas pendientes
        $ventas_culminadas = Purchase::where('status', 2)->get(); // ventas culminadas

        return view('sidebar.ventas.index', [
            'ventas_pendientes' => $ventas_pendientes,
            'ventas_culminadas' => $ventas_culminadas
        ]);
    }

    public function ventasCreate()
    {
        $entities = Entity::whereHas('products', function($q){
            $q->where('status', 'Disponible');
        })->get();

        return view('sidebar.ventas.create', [
            'entities' => $entities,
        ]);
    }
}
