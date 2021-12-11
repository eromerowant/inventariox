@extends('adminlte::page')

@section('title', 'Compra')

@section('css')
@stop

@section('content')
    <div id="appVue">

        {{-- nueva-venta --}}
        <div class="container-fluid">
            <div class="row text-center">
                <div class="col-12">
                    <h3>Venta ID: {{ $sale->id }}</h3>
                    <p>Fecha: {{ $sale->created_at->format('d-m-Y H:i') }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    @foreach ($sale->products as $product)
                        <p>Nombre: <strong>{{ $product->entity->name }}</strong></p>
                        <p>
                            <span>Costo Unitario: <strong>{{ $product->single_cost_when_bought }}, </strong></span>
                            <span>Precio de Venta: <strong>{{ $product->final_sale_price }}, </strong></span>
                            <span>Ganancia Total: <strong>{{ $product->final_profit_on_sale }}, </strong></span>
                        </p>
                        <p>
                            <a href="{{ route('compras.show', ['compra_id' => $product->purchase_id]) }}">
                                Pertenece a la compra {{ $product->purchase->created_at->format('d-m-Y H:i') }}
                            </a>
                        </p>
                        <p>
                            Descripción:
                            @foreach ($product->values as $value)
                                <span>{{ $value->attribute->name }}: <strong>{{ $value->name }}</strong>, </span>
                            @endforeach
                        </p>
                        <hr>
                    @endforeach
                </div>
            </div>


        </div>
        {{-- /nueva-venta --}}

    </div>
@stop
