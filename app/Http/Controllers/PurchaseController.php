<?php

namespace App\Http\Controllers;

use App\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function delete_purchase( Request $request )
    {
        $purchase = Purchase::where('id', $request->get('compra_id'))->first();
        foreach ($purchase->products as $product) {
            $product->delete();
        }
        $purchase->delete();

        return redirect()->route('compras.index');

    }
}
