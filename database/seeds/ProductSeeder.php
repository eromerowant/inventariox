<?php

use Illuminate\Database\Seeder;

use App\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        factory(Product::class, 200)->create();
    }
}
