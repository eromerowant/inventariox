@extends('adminlte::page')

@section('title', 'Compra')

@section('content')

   {{-- nueva-compra --}}
   <div class="container-fluid">
      <div class="row text-center">
            <div class="col">
               <h3>Compra id: {{ $compra->id }}</h3>
            </div>
      </div>

      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-body">
                  <div class="row">
                     <div class="col">
                        <div class="form-group">
                           <label for="">Nombre del Producto</label>
                           <input type="text" class="form-control" value="{{ $compra->ejemplar->nombre }}" readonly>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     @foreach ( json_decode($compra->ejemplar->atributos) as $key => $value)
                        <div class="col">
                              <div class="form-group">
                                 <label>{{ $key }}</label>
                                 <input type="text" class="form-control" value="{{ $value }}" readonly>
                              </div>
                        </div>
                     @endforeach
                  </div>

                  <hr class="bg-dark">
                  <br>
   
                  <div class="row">
                     <div class="col">
                        <div class="form-group">
                           <label>Cantidad de Unidades</label>
                           <input type="text" class="form-control" value="{{ $compra->cantidad }}" readonly>
                        </div>
                     </div>
                     <div class="col">
                        <div class="form-group">
                           <label>Monto Total Pagado</label>
                           <input type="text" class="form-control" value="{{ $compra->precio_total }}" readonly>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col">
                        <div class="form-group">
                           <label>Monto Unitario (c/u)</label>
                           <input type="text" class="form-control" value="{{ $compra->productos[0]->costo_unitario }}" readonly>
                        </div>
                     </div>
                     <div class="col">
                        <div class="form-group">
                           <label>Precio Sugerido (c/u)</label>
                           <input type="text" class="form-control"  value="{{ $compra->productos[0]->precio_sugerido }}" readonly>
                        </div>
                     </div>
                  </div>

                  @if ($compra->status == 1)
                     <div class="row">
                        <div class="col">
                           <form action="{{ route('recibir_compra', ['compra_id' => $compra->id]) }}" method="POST">
                              @csrf
                              <button class="btn btn-success btn-sm" type="submit">Recibir compra</button>
                           </form>
                        </div>
                     </div>
                  @else
                     <div class="row">
                        <div class="col">
                           <form action="{{ route('compra_en_camino', ['compra_id' => $compra->id]) }}" method="POST">
                              @csrf
                              <button class="btn btn-danger btn-sm" type="submit">Compra en camino</button>
                           </form>
                        </div>
                     </div>
                  @endif

               </div>
            </div>
         </div>
      </div>
   </div>
   {{-- /nueva-compra --}}

@stop
