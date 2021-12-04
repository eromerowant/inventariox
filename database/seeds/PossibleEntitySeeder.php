<?php

use Illuminate\Database\Seeder;

use App\PossibleEntity;

class PossibleEntitySeeder extends Seeder
{
    public function run()
    {
        factory(PossibleEntity::class, 20)->create();
    }
}
