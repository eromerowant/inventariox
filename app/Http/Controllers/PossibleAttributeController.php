<?php

namespace App\Http\Controllers;

use App\PossibleAttribute;
use Illuminate\Http\Request;

use App\PossibleValue;

class PossibleAttributeController extends Controller
{
    public function addNewAttributeInDataBase( Request $request )
    {
        $attributo = new PossibleAttribute();
        $attributo->name = $request->get('name');
        $attributo->possible_entity_id = $request->get('entidad_id');
        $attributo->save();

        return response()->json($attributo->load('values'));
    }

    public function removeAttributeFromEntity( Request $request )
    {
        $attribute = PossibleAttribute::where('id', $request->get('attribute_id'))->first();
        $entity = $attribute->entity;
        $attribute->delete();

        return response()->json( $entity->load('attributes', 'attributes.values') );
    }

    public function updateAttributeInEntity( Request $request )
    {
        $attribute = PossibleAttribute::where('id', $request->get('attribute_id'))->first();
        $entity = $attribute->entity;
        $attribute->name = $request->get('new_value');
        $attribute->update();

        return response()->json( $entity->load('attributes', 'attributes.values') );
    }

    public function addNewValueToPossibleAttribute( Request $request )
    {
        $value = new PossibleValue();
        $value->name = $request->get('newValue');
        $value->possible_attribute_id = $request->get('attr_id');
        $value->save();

        $entity = $value->attribute->entity->load('attributes', 'attributes.values');
        
        return response()->json( $entity );
    }

    public function removeValueFromAttributeInDatabase( Request $request )
    {
        $value = PossibleValue::where('id', $request->get('value_id'))->first();
        $entity = $value->attribute->entity;
        
        $value->delete();
        
        return response()->json( $entity->load('attributes', 'attributes.values') );
    }
}
