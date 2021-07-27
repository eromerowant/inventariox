<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Compra;
use App\Ejemplare;
use App\Producto;
use App\Entidade;

class SidebarController extends Controller
{
    public function configuracion()
    {
        return view('sidebar.configuracion');
    }

    public function comprasIndex()
    {
        $compras_en_camino = Compra::where('status', 1)->get(); // Compras en camino
        $compras_recibidas = Compra::where('status', 2)->get(); // Compras recibidas

        return view('sidebar.compras.index', [
            'compras_en_camino' => $compras_en_camino,
            'compras_recibidas' => $compras_recibidas
        ]);
    }

    public function inventarioIndex()
    {
        // $productos_en_camino = Producto::where('status', 1)->get(); // productos en camino
        // $productos_recibidos = Producto::where('status', 2)->get(); // productos recibidas
        $ejemplares = Ejemplare::all();

        return view('sidebar.inventario.index', [
            'ejemplares' => $ejemplares
        ]);
    }

    public function comprasCreate()
    {
        $entidades = Entidade::select('id', 'nombre')->get();
        return view('sidebar.compras.create', ['entidades' => $entidades]);
    }

    public function comprasShow($compra_id)
    {
        $compra = Compra::with('productos', 'ejemplar')->where('id', $compra_id)->first();

        return view('sidebar.compras.show', ['compra' => $compra]);
    }

    public function ventasIndex()
    {
        $ventas_pendientes = Compra::where('status', 1)->get(); // ventas pendientes
        $ventas_culminadas = Compra::where('status', 2)->get(); // ventas culminadas

        return view('sidebar.ventas.index', [
            'ventas_pendientes' => $ventas_pendientes,
            'ventas_culminadas' => $ventas_culminadas
        ]);
    }

    public function ventasCreate()
    {
        return view('sidebar.ventas.create');
    }
}
