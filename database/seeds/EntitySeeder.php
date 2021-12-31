<?php

use Illuminate\Database\Seeder;

use App\Entity;

class EntitySeeder extends Seeder
{
    public function run()
    {
        factory(Entity::class, 20)->create();
    }
}
