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
                @if ($compra->status === 'Pendiente')
                    <form action="{{ route('recibir_compra', ['compra_id' => $compra->id]) }}" method="POST">
                        @csrf
                        <input type="submit" value="Paquete recibido" class="btn btn-sm btn-success">
                    </form>
                @else
                    <form action="{{ route('compra_en_camino', ['compra_id' => $compra->id]) }}" method="POST">
                        @csrf
                        <input type="submit" value="Me equivoqué, no la he recibido aún." class="btn btn-sm btn-success">
                    </form>
                @endif
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                @foreach ($compra->products as $product)
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <p>Nombre del Producto: <b>{{ $product->entity->name }}</b> - ID: {{ $product->id }}
                                    </p>
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
                                    <p>Precio en el que fue finalmente vendido:
                                        <b>{{ $product->final_sale_price ?? 'Aún no ha sido vendido' }}</b></p>
                                </div>
                                <div class="col-12">
                                    <p>Ganancia final después de haber sido vendido:
                                        <b>{{ $product->final_profit_on_sale ?? 'Aún no ha sido vendido' }}</b></p>
                                </div>
                                <div class="col-12">
                                    <p>Atributos:</p>
                                    @foreach ($product->values as $value)
                                        <span>{{ $value->attribute->name }}: <b>{{ $value->name }}</b>, </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {{-- /nueva-compra --}}

@stop
