<?php

use Illuminate\Database\Seeder;

use App\Purchase;

class PurchaseSeeder extends Seeder
{
    public function run()
    {
        factory(Purchase::class, 50)->create();
    }
}
