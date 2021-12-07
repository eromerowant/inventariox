<?php

use Illuminate\Database\Seeder;

use App\PossibleEntity;
use App\PossibleAttribute;
use App\PossibleValue;

class PossibleEntitySeeder extends Seeder
{
    public function run()
    {
        // factory(PossibleEntity::class, 20)->create();

        foreach (config('constantes.possible_entities') as $entity_name => $entity_attributes) {
            $possible_entity = new PossibleEntity();
            $possible_entity->name = $entity_name;
            $possible_entity->save();
            foreach ($entity_attributes as $attribute => $values) {
                $possible_attribute = new PossibleAttribute();
                $possible_attribute->name = $attribute;
                $possible_attribute->possible_entity_id = $possible_entity->id;
                $possible_attribute->save();
                foreach ($values as $value) {
                    $possible_value = new PossibleValue();
                    $possible_value->name = $value;
                    $possible_value->possible_attribute_id = $possible_attribute->id;
                    $possible_value->save();
                }
            }
        }
    }
}
