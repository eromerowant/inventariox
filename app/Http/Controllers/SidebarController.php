<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Compra;
use App\Entidade;

class SidebarController extends Controller
{
    public function configuracion()
    {
        return view('sidebar.configuracion');
    }

    public function comprasIndex()
    {
        $compras = Compra::all();
        return view('sidebar.compras.index', ['compras' => $compras]);
    }

    public function comprasCreate()
    {
        $entidades = Entidade::select('id', 'nombre')->get();
        return view('sidebar.compras.create', ['entidades' => $entidades]);
    }
}
