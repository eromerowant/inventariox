<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Bitacora;
use App\Compra;
use Illuminate\Support\Facades\DB;
use App\Ejemplare;
use App\Producto;
use Illuminate\Http\Request;

class CompraController extends Controller
{

    public function comprasRegistradasYPendientes()
    {
        $compras_registradas = Compra::where('status', 1)->get(); // En espera

        foreach ($compras_registradas as $key => $value) {
            $compras_registradas[$key]['productos'] = $value->productos;
            foreach ($compras_registradas[$key]['productos'] as $pos => $producto) {
                $compras_registradas[$key]['productos'][$pos]['ejemplar'] = $producto->ejemplar;
                $compras_registradas[$key]['productos'][$pos]['ejemplar']['atributos'] = json_decode($compras_registradas[$key]['productos'][$pos]['ejemplar']['atributos']);
            }
        }

        return response()->json(['compras_registradas' => $compras_registradas]);
    }

    public function comprasRegistradasYRecibidas()
    {
        $compras_registradas = Compra::where('status', 2)->get(); // Recibidas

        foreach ($compras_registradas as $key => $value) {
            $compras_registradas[$key]['productos'] = $value->productos;
            foreach ($compras_registradas[$key]['productos'] as $pos => $producto) {
                $compras_registradas[$key]['productos'][$pos]['ejemplar'] = $producto->ejemplar;
                $compras_registradas[$key]['productos'][$pos]['ejemplar']['atributos'] = json_decode($compras_registradas[$key]['productos'][$pos]['ejemplar']['atributos']);
            }
        }

        return response()->json(['compras_registradas' => $compras_registradas]);
    }


    public function registrarNuevaCompra(Request $request)
    {
        // Validaciones
        // Verificar que el ejemplar ya exista, pra no repetirlo en base de datos.
        $new_ejemplar = null;
        $el_ejemplar_ya_existe = false;
        $ejemplares_existente = Ejemplare::all();
        foreach ($ejemplares_existente as $ejemplar) {
            if ($ejemplar->nombre === $request->input('entidadSeleccionada') && $ejemplar->atributos === json_encode($request->input('atributos_selected'))) {
                $el_ejemplar_ya_existe = true;
                $new_ejemplar = $ejemplar;
            }
        }

        // Registrar nuevo ejemplar
        if (!$el_ejemplar_ya_existe) {
            $new_ejemplar = new Ejemplare();
            $new_ejemplar->nombre = $request->input('entidadSeleccionada');
            $new_ejemplar->atributos = json_encode($request->input('atributos_selected'));
            $new_ejemplar->cantidad_disponible = 0;
            $new_ejemplar->save();
        }

        // Registrar la compra
        $new_compra = new Compra();
        $new_compra->cantidad = $request->input('cantidad_de_unidades');
        $new_compra->precio_total = $request->input('monto_total_pagado');
        $new_compra->enlace_url = $request->input('enlace_url');
        $new_compra->ejemplar_id = $new_ejemplar->id;
        $new_compra->save();
        // $new_compra->status = 1; // Productos pendientes por recibir

        // Registrar los productos
        $productos = [];
        for ($i=1; $i <= $request->input('cantidad_de_unidades'); $i++) { 
            $new_producto = new Producto();
            $new_producto->ejemplar_id = $new_ejemplar->id;
            $new_producto->compra_id = $new_compra->id;
            $new_producto->costo_unitario = $request->input('costoPorUnidad');
            $new_producto->precio_sugerido = $request->input('precio_sugerido');
            $new_producto->status = 1;
            // $new_producto->qr_code = null;
            $new_producto->save();
            $productos[$i] = $new_producto;
        }

        $response = [
            'new_ejemplar' => $new_ejemplar,
            'new_compra' => $new_compra,
            'productos' => $productos
        ];

        return response()->json($response);
    }

    public function eliminarCompraRegistrada(Request $request)
    {
        if ($request->input('compra_id')) {
            $compra = Compra::findOrFail($request->input('compra_id'));
            if ($compra) {
                // Buscamos los productos
                $productos = Producto::where('compra_id', $compra->id)->get();
                $productos_borrados = [];
                if (count($productos) > 1) { // plural
                    foreach ($productos as $producto) {
                        array_push($productos_borrados, $producto->id);
                        $producto->delete();
                    }
                } else if(count($productos) === 1){ // singular
                    array_push($productos_borrados, $productos->id);
                    $productos->delete();
                }
                // borramos la compra
                $id = $compra->id;
                $compra->delete();
            }
            // registramos el acontecimiento:
            $bitacora = new Bitacora();
            $el_usuario =  "el usuario: ".Auth::user()->name." con ID: ".Auth::user()->id;
            $bitacora->suceso = $el_usuario.", eliminó la compra con id: ".$id.", y se borraron los siguientes productos con id: ".json_encode($productos_borrados);
            $bitacora->save();

            return response()->json(['compra_id_borrada' => $id]);
        }
        return response()->json(['error' => 'hubo un error']);
    }

    public function CambiarStatusDeCompraARecibida(Request $request)
    {
        if ($request->input('compra_id')) {
            $compra = Compra::where('id', $request->input('compra_id'))->first();
            $compra->status = 2; // Compra Recibida
            $compra->save();

            $productos = Producto::where('compra_id', $compra->id)->get();
            foreach ($productos as $producto) {
                $producto->status = 2; //Disponible
                $producto->save();
            }
            $ejemplar = Ejemplare::where('id', $productos[0]->ejemplar_id)->first();
            $ejemplar->cantidad_disponible += count($productos);
            $ejemplar->save();

            $bitacora = new Bitacora();
            $el_usuario =  "el usuario: ".Auth::user()->name." con ID: ".Auth::user()->id;
            $bitacora->suceso = $el_usuario.", cambió el status de la compra con id: ".$compra->id.", a status 2 (Compra Recibida), todos sus productos relacionados pasaron a estar disponibles y se sumaron ".count($productos)." a la cantidad_disponible en la tabla ejemplares.";
            $bitacora->save();

            return response()->json(['compra_id_con_nuevo_status_2' => $compra->id]);
        }
        return response()->json(['error' => 'hubo un error']);
    }

    public function CambiarStatusDeCompraAPendiente(Request $request)
    {
        if ($request->input('compra_id')) {
            $compra = Compra::where('id', $request->input('compra_id'))->first();
            $compra->status = 1; // Compra PENDIENTE
            $compra->save();

            $productos = Producto::where('compra_id', $compra->id)->get();
            foreach ($productos as $producto) {
                $producto->status = 1; // En Espera
                $producto->save();
            }
            $ejemplar = Ejemplare::where('id', $productos[0]->ejemplar_id)->first();
            $ejemplar->cantidad_disponible -= count($productos);
            $ejemplar->save();

            $bitacora = new Bitacora();
            $el_usuario =  "el usuario: ".Auth::user()->name." con ID: ".Auth::user()->id;
            $bitacora->suceso = $el_usuario.", cambió el status de la compra con id: ".$compra->id.", a status 1 (Sin Recibir), todos sus productos relacionados pasaron a estar EN ESPERA, y se restaron ".count($productos)." a la cantidad_disponible en la tabla ejemplares.";
            $bitacora->save();

            return response()->json(['compra_id_con_nuevo_status_1' => $compra->id]);
        }
        return response()->json(['error' => 'hubo un error']);
    }

}
