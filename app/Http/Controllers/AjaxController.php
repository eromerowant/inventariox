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
        $sales = Sale::where('status', 'Finalizada')->with( $relations )
                                                    ->withCount('products');
                                                    
        
        return DataTables::eloquent( $sales )
                            ->filter(function ($query) use ($request) {
                                if ( $request->get('search_by_final_amount') ) {
                                    $query->where('final_amount', $request->get('search_by_final_amount'));
                                }
                                if ( $request->get('search_by_final_cost') ) {
                                    $query->where('final_cost', $request->get('search_by_final_cost'));
                                }
                                if ( $request->get('search_by_final_profit') ) {
                                    $query->where('final_profit', $request->get('search_by_final_profit'));
                                }
                                if ( $request->get('search_by_month') ) {
                                    $query->whereMonth('created_at', $request->get('search_by_month'));
                                }
                                if ( $request->get('search_by_anio') ) {
                                    $query->whereYear('created_at', $request->get('search_by_anio'));
                                }
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
                            ->addColumn('total_ganancia', function ($sale) use ($sales) {
                                $suma = $sales->sum('final_profit');
                                return number_format($suma, 2, ",", ".")." (".$sales->count().")";
                            })
                            ->addColumn('total_venta', function ($sale) use ($sales) {
                                $suma = $sales->sum('final_amount');
                                return number_format($suma, 2, ",", ".")." (".$sales->count().")";
                            })
                            ->addColumn('total_costo', function ($sale) use ($sales) {
                                $suma = $sales->sum('final_cost');
                                return number_format($suma, 2, ",", ".")." (".$sales->count().")";
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
