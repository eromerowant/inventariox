<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Bitacora;
use App\Entidade;
use Illuminate\Http\Request;

class EntidadeController extends Controller
{

    public function index()
    {
        $entidades_existentes = Entidade::all();
        return response()->json(['entidades_registradas' => $entidades_existentes]);
    }

    public function storeNewEntidad(Request $request)
    {
        if (!empty($request->input('nombre_entidad'))) {
            //revisamos la base de datos 
            $entidades_existentes = Entidade::all();

            foreach ($entidades_existentes as $key => $value) {
                if ($value->nombre === $request->input('nombre_entidad')) {
                    return response()->json(['entidad_existente' => $value]);
                }
            }
            $entidad = new Entidade();
            $entidad->nombre = $request->input('nombre_entidad');
            $entidad->atributos = "[]";
            $entidad->save();

            $bitacora = new Bitacora();
            $el_usuario =  "el usuario: ".Auth::user()->name." con ID: ".Auth::user()->id;
            $bitacora->suceso = $el_usuario." agregó una nueva entidad con id: ".$entidad->id;
            $bitacora->save();
            return response()->json(['entidad_agregada' => $entidad]);
        }
        return response()->json(['error' => 'Hubo un error']);
    }

    public function storeNewAtributo(Request $request)
    {
        if (!empty($request->input('entidad_id'))) {
            $entidad_existente = Entidade::where('id', $request->input('entidad_id'))->first();
            $entidad_existente->atributos = $request->input('atributos');
            $entidad_existente->update();

            $bitacora = new Bitacora();
            $el_usuario =  "el usuario: ".Auth::user()->name." con ID: ".Auth::user()->id;
            $bitacora->suceso = $el_usuario." actualizó los atributos de la entidad con id: ".$entidad_existente->id;
            $bitacora->save();

            return response()->json(['respuesta' => "atributos actualizados en la entidad con ID: ".$entidad_existente->id]);
        }
        return response()->json(['error' => 'Hubo un error']);
    }

    public function borrarEntidadExistente(Request $request)
    {
        if ( !empty( $request->input('entidad_id') ) ) {
            $entidad_existente = Entidade::where('id', $request->input('entidad_id'))->first();
            $entidad = $entidad_existente;
            $entidad_existente->delete();

            $bitacora = new Bitacora();
            $el_usuario =  "el usuario: ".Auth::user()->name." con ID: ".Auth::user()->id;
            $bitacora->suceso = $el_usuario." borró exitosamente la entidad: ".$entidad;
            $bitacora->save();

            return response()->json(['entidad_borrada' => $entidad]);
        }
        return response()->json(['error' => 'Hubo un error']);
    }

    public function updateAtributosDeEntidad(Request $request)
    {
        if ( !empty( $request->input('entidad_id') ) ) {
            $entidad_existente = Entidade::where('id', $request->input('entidad_id'))->first();
            $entidad_existente->atributos = $request->input('atributos');
            $entidad_existente->update();

            $bitacora = new Bitacora();
            $el_usuario =  "el usuario: ".Auth::user()->name." con ID: ".Auth::user()->id;
            $bitacora->suceso = $el_usuario." actualizó los atributos de la entidad con id: ".$entidad_existente;
            $bitacora->save();

            return response()->json(['atributos_actualizados_en_entidad' => $entidad_existente]);
        }
        return response()->json(['error' => 'Hubo un error']);
    }

}
