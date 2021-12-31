<?php

use Illuminate\Database\Seeder;

use App\Sale;

class SaleSeeder extends Seeder
{
    public function run()
    {
        factory(Sale::class, 100)->create();
    }
}
