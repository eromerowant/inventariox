<?php

namespace App\Http\Controllers;

use App\Ejemplare;
use Illuminate\Http\Request;

use App\Product;

class EjemplareController extends Controller
{
    public function index()
    {
        $productos_disponibles = Product::where('status', "Disponible")->get();

        return response()->json(['productos_disponibles' => $productos_disponibles]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Ejemplare $ejemplare)
    {
        //
    }

    public function edit(Ejemplare $ejemplare)
    {
        //
    }

    public function update(Request $request, Ejemplare $ejemplare)
    {
        //
    }

    public function destroy(Ejemplare $ejemplare)
    {
        //
    }
}
