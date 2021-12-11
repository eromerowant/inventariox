<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;
use App\Sale;
use Carbon\Carbon;

class AjaxController extends Controller
{
    public function get_finished_sales(Request $request)
    {
        $relations = [
            'products',
        ];
        $sales = Sale::where('status', 'Finalizada')->with( $relations )->withCount('products');

        return DataTables::eloquent( $sales )
                            ->filter(function ($query) use ($request) {
                                //
                            })
                            ->addColumn('productos', function ($sale) {
                                return $sale->products->count();
                            })
                            ->addColumn('fecha', function ($sale) {
                                return $sale->created_at->format('d-m-Y H:i');
                            })
                            ->addColumn('action', function ($sale) {
                                return '<a href="'.route('sales.show', ['sale_id' => $sale->id]).'" class="btn btn-sm btn-info">Ver Detalle</a>';
                            })
                            ->orderColumn('productos', function ($query, $order) {
                                $query->orderBy('products_count', $order);
                            })
                            ->orderColumn('fecha', function ($query, $order) {
                                $query->orderBy('created_at', $order);
                            })
                            ->editColumn('final_amount', function ($sale) {
                                return number_format($sale->final_amount, 2, ",", ".");
                            })
                            ->editColumn('final_cost', function ($sale) {
                                return number_format($sale->final_cost, 2, ",", ".");
                            })
                            ->editColumn('final_profit', function ($sale) {
                                return number_format($sale->final_profit, 2, ",", ".");
                            })
                            ->toJson();
    }
}
