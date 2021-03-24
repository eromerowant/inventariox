<?php

namespace App\Http\Controllers;

use App\Ejemplare;
use Illuminate\Http\Request;

class EjemplareController extends Controller
{
    public function index()
    {
        $ejemplares = Ejemplare::all();
        $ejemplares_filtrados = [];
        foreach ($ejemplares as $key => $ejemplar) {
            $nombre_existente_en_variable_ejemplares_filtrados = in_array($ejemplar->nombre, $ejemplares_filtrados);
            if (!$nombre_existente_en_variable_ejemplares_filtrados) {
                $nuevo_nombre = $ejemplar->nombre;
                $ejemplares_filtrados[$nuevo_nombre][$key] = [];
                $ejemplares_filtrados[$nuevo_nombre][$key]['atributo'] = json_decode($ejemplar->atributos);
                $ejemplares_filtrados[$nuevo_nombre][$key]['cantidad_disponible'] = $ejemplar->cantidad_disponible;
            } else {
                $nombre_existente = $ejemplar->nombre;
                $ejemplares_filtrados[$nombre_existente][$key]['atributo'] = json_decode($ejemplar->atributos);
                $ejemplares_filtrados[$nombre_existente][$key]['cantidad_disponible'] = $ejemplar->cantidad_disponible;
            }
        }

        return response()->json(['ejemplares' => $ejemplares_filtrados]);
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
