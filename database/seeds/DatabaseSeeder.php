<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(PossibleEntitySeeder::class);
        $this->call(PossibleAttributeSeeder::class);
        $this->call(PossibleValueSeeder::class);


        
        $this->call(EntitySeeder::class);
        $this->call(PurchaseSeeder::class);
        $this->call(SaleSeeder::class);
        $this->call(ProductSeeder::class);
    }
}
