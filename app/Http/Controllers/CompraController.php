<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Bitacora;
use App\Compra;
use Illuminate\Support\Facades\DB;
use App\Ejemplare;
use App\Producto;
use Illuminate\Http\Request;

use App\Product;
use App\Purchase;
use App\Attribute;
use App\Entity;
use App\Value;
use App\ValueProduct;

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
        $entity_registered = Entity::where('name', $request->get('entidadSeleccionada'))->first();
        if ( $entity_registered ) {
            $entity = $entity_registered;
        } else {
            $entity = new Entity();
            $entity->name = $request->get('entidadSeleccionada');
            $entity->save();
        }



        $purchase = new Purchase();
        $purchase->final_amount = $request->get('monto_total_pagado');
        $purchase->status       = "Pendiente";
        $purchase->save();

        for ($i = 1; $i <= $request->get('cantidad_de_unidades'); $i++) {
            $product = new Product();
            $product->entity_id               = $entity->id;
            $product->purchase_id             = $purchase->id;
            $product->single_cost_when_bought = $request->get('costoPorUnidad');
            $product->suggested_price         = $request->get('precio_sugerido');
            $product->suggested_profit        = $request->get('precio_sugerido') - $request->get('costoPorUnidad');
            $product->status                  = "Pendiente";
            $product->save();

            foreach ($request->get('atributos_selected') as $attr_name => $attr_value) {
                $atributo_existente = Attribute::where('name', $attr_name)->first();
    
                if ( $atributo_existente ) {
                    $new_attribute = $atributo_existente;
                    if ( !$new_attribute->entities->contains( $entity->id ) ) {
                        $new_attribute->entities()->attach( $entity->id );
                    }
                } else {
                    $new_attribute        = new Attribute();
                    $new_attribute->name  = $attr_name;
                    $new_attribute->save();
                    $new_attribute->entities()->attach( $entity->id );
                }
    
                $value_existente = Value::where('name', $attr_value)->where('attribute_id', $new_attribute->id)->first();
                if ( $value_existente ) {
                    $new_value = $value_existente;
                } else {
                    $new_value                = new Value();
                    $new_value->name          = $attr_value;
                    $new_value->attribute_id  = $new_attribute->id;
                    $new_value->save();
                }

                $product->values()->attach( $new_value->id );

            }
        }

        return response()->json( "ok" );
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

    public function recibir_compra( Request $request )
    {
        $compra = Purchase::where('id', $request->get('compra_id'))->first();
        $compra->status = "Recibida";
        $compra->update();

        foreach ($compra->products as $product) {
            $product->status = "Disponible";
            $product->update();
        }

        return redirect()->action([SidebarController::class, 'comprasIndex']);
    }

    public function compra_en_camino(Request $request)
    {
        $compra = Purchase::where('id', $request->get('compra_id'))->first();
        $compra->status = "Pendiente";
        $compra->update();

        foreach ($compra->products as $product) {
            $product->status = "Pendiente";
            $product->update();
        }

        return redirect()->action([SidebarController::class, 'comprasIndex']);
    }

}
