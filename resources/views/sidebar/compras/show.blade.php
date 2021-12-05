@extends('adminlte::page')

@section('title', 'Compra')

@section('content')

    {{-- nueva-compra --}}
    <div class="container-fluid">
        <div class="row text-center">
            <div class="col">
                <h3>Compra id: {{ $compra->id }}</h3>
                <p>Fecha: {{ $compra->created_at->format('d-m-Y') }}</p>
                <p>Monto Pagado: {{ $compra->final_amount }}</p>
                <p>Cantidad de productos: {{ count($compra->products) }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @foreach ($compra->products as $product)
                            <div class="row">
                                <div class="col-12">
                                    <p>Nombre del Producto: <b>{{ $product->name }}</b> - ID: {{$product->id  }}</p>
                                </div>
                                <div class="col-12">
                                    <p>Costo por unidad: <b>{{ $product->single_cost_when_bought }}</b></p>
                                </div>
                                <div class="col-12">
                                    <p>Precio Sugerido: <b>{{ $product->suggested_price }}</b></p>
                                </div>
                                <div class="col-12">
                                    <p>Ganancia Probable: <b>{{ $product->suggested_profit }}</b></p>
                                </div>
                                <div class="col-12">
                                    <p>Precio en el que fue finalmente vendido: <b>{{ $product->final_sale_price ?? "Aún no ha sido vendido" }}</b></p>
                                </div>
                                <div class="col-12">
                                    <p>Ganancia final después de haber sido vendido: <b>{{ $product->final_profit_on_sale ?? "Aún no ha sido vendido" }}</b></p>
                                </div>
                                <div class="col-12">
                                    @foreach ( $product->attributes as $attr)
                                        <table class="table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>N°</th>
                                                    <th>Atributos</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $attr->name }}- {{ $attr->value }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @endforeach
                                </div>
                            </div>
                            <hr>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- /nueva-compra --}}

@stop
