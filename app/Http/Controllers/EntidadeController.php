<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Bitacora;
use App\Entidade;
use Illuminate\Http\Request;

use App\PossibleAttribute;
use App\PossibleEntity;

class EntidadeController extends Controller
{

    public function index()
    {
        $entidades_existentes = PossibleEntity::with('attributes', 'attributes.values')->get();
        return response()->json(['entidades_registradas' => $entidades_existentes]);
    }

    public function storeNewEntidad(Request $request)
    {
        if ( !$request->get('name') ) {
            return response()->json([
                'message' => "Por favor envía el nombre de entidad",
            ], 400);
        }
        $name = $request->input('name');

        $entity_already_exists = PossibleEntity::where('name', $name)->first();
        if ( $entity_already_exists ) {
            return response()->json(['entidad_registrada' => $entity_already_exists->load('attributes', 'attributes.values')]);
        } else {
            $new_entity = new PossibleEntity();
            $new_entity->name = $name;
            $new_entity->save();
            return response()->json(['entidad_registrada' => $new_entity->load('attributes', 'attributes.values')]);
        }

    }

    public function borrarEntidadExistente(Request $request)
    {
        if ( !$request->get('entidad_id') ) {
            return response()->json([
                'message' => "Por favor envía entidad_id",
            ], 400);
        }
        $id = $request->get('entidad_id');
        $entidad_existente = PossibleEntity::where('id', $id)->first();
        $entidad_existente->delete();

        return response()->json(['message' => "entidad con id $id borrado correctamente."]);
    }

    public function updateAtributosDeEntidad(Request $request)
    {
        if ( !$request->get('entidad_id') || !$request->get('atributos')) {
            return response()->json(['message' => 'Faltan los atributos ó la entidad_id'], 400);
        }

        foreach ($request->get('atributos') as $requested_attribute) {
            $new_attribute = new PossibleAttribute();
            $new_attribute->name = $request->get('atributos')['nombre'];
            $new_attribute->possible_entities_id = $request->get('entidad_id');
            $new_attribute->save();
        }
        return response()->json(['message' => 'Atributos registrados exitosamente']);

    }

    public function get_entidad(Request $request)
    {
        $entidad = Entidade::where('nombre', $request->get('entidad') )->first();
        return response()->json($entidad);
    }

}
