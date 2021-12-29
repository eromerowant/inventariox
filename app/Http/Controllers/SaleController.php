<?php

namespace App\Http\Controllers;

use App\Sale;
use Illuminate\Http\Request;

use App\Product;

class SaleController extends Controller
{
    public function register_new_sale( Request $request )
    {
        // dd( $request->all() );
        $new_sale = new Sale();
        $new_sale->final_amount = $request->get('precio_final_toda_la_cesta');
        $new_sale->final_cost   = $request->get('total_unitario_cesta');
        $new_sale->final_profit = $request->get('total_ganancia');
        $new_sale->status = 'Finalizada';
        $new_sale->save();

        foreach ($request->get('cesta') as $entity) {
            foreach ($entity['combinations'] as $combination) {
                if ( count($combination['products']) > 0 ) {
                    $final_sale_price_in_combination          = $combination['precio_final'];
                    $quantity_of_products_in_this_combination = count($combination['products']);

                    foreach ($combination['products'] as $product_in_combination) {
                        $product = Product::where('id', $product_in_combination['id'] )->first();
                        $product->sale_id = $new_sale->id;
                        $product->final_sale_price = ($final_sale_price_in_combination / $quantity_of_products_in_this_combination);
                        $product->final_profit_on_sale = ($product->final_sale_price - $product->single_cost_when_bought);
                        $product->status = "Vendido";
                        $product->save(); 
                    }
                }
            }
        }

        return response()->json([
            'ruta' => route('sales.show', ['sale_id' => $new_sale->id]),
        ]);
    }

    public function show( $sale_id )
    {
        $relations = [
            'products',
            'products.values',
            'products.values.attribute',
        ];
        $sale = Sale::where('id', $sale_id)->with($relations)->first();
        return view('sales.show', [
            'sale' => $sale,
        ]);
    }

    public function delete_sale( Request $request )
    {
        $sale = Sale::where('id', $request->get('sale_id'))->first();
        foreach ($sale->products as $product) {
            $product->sale_id              = null; 
            $product->final_sale_price     = null; 
            $product->final_profit_on_sale = null; 
            $product->status               = "Disponible"; 
            $product->update(); 
        }
        $sale->delete();

        return redirect()->route('ventas.index')->with('success', "Se eliminó correctamente la venta ".$request->get('sale_id')." y los productos ahora estan disponibles nuevamente.");
    }
}
