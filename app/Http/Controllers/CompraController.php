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

    public function comprasRegistradas()
    {
        $compras_registradas = Compra::all();

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
        $el_ejemplar_ya_existe = false;
        $ejemplares_existente = Ejemplare::all();
        foreach ($ejemplares_existente as $ejemplar) {
            if ($ejemplar->nombre === $request->input('nombreDeEntidadSeleccionadaParaComprar') && $ejemplar->atributos === json_encode($request->input('atributos'))) {
                $el_ejemplar_ya_existe = true;
                $new_ejemplar = $ejemplar;
            }
        }

        // Registrar nuevo ejemplar
        if (!$el_ejemplar_ya_existe) {
            $new_ejemplar = new Ejemplare();
            $new_ejemplar->nombre = $request->input('nombreDeEntidadSeleccionadaParaComprar');
            $new_ejemplar->atributos = json_encode($request->input('atributos'));
            $new_ejemplar->cantidad_disponible = 0;
            $new_ejemplar->save();
        }

        // Registrar la compra
        $new_compra = new Compra();
        $new_compra->cantidad = $request->input('cantidadItemsEnCompra');
        $new_compra->precio_total = $request->input('montoTotalPagado');
        $new_compra->enlace_url = $request->input('enlaceURLDeLaCompra');
        $new_compra->save();
        // $new_compra->status = 1; // Productos pendientes por recibir

        // Registrar los productos
        $productos = [];
        for ($i=1; $i <= $request->input('cantidadItemsEnCompra'); $i++) { 
            $new_producto = new Producto();
            $new_producto->ejemplar_id = $new_ejemplar->id;
            $new_producto->compra_id = $new_compra->id;
            $new_producto->costo_unitario = $request->input('costoPorUnidad');
            $new_producto->precio_sugerido = $request->input('precioSugerido');
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

        $bitacora = new Bitacora();
        $el_usuario =  "el usuario: ".Auth::user()->name." con ID: ".Auth::user()->id;
        $bitacora->suceso = $el_usuario.", registró una compra bajo el ID: ".$new_compra->id;
        $bitacora->save();

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

}
