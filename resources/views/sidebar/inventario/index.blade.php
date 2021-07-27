@extends('adminlte::page')

@section('title', 'Inventario')

@section('css')
@stop

@section('content')
   <div id="appVue">

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h1 class="text-center m-2">Productos</h1>
                                    <table id="tabla_de_productos_en_camino" class="table-hover" style="width:100%">
                                       <thead>
                                          <tr>
                                             <th>N°</th>
                                             <th>Id</th>
                                             <th>Nombre</th>
                                             <th>Caracteristicas</th>
                                             <th>Cantidad Disponible</th>
                                             <th class="no_exportar">Acciones</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach ($ejemplares as $ejemplar)
                                             <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $ejemplar->id }}</td>
                                                <td>{{ $ejemplar->nombre }}</td>
                                                <td>
                                                    @foreach (json_decode($ejemplar->atributos) as $item => $value)
                                                        {{ $item .': '. $value.", " }}
                                                    @endforeach
                                                </td>
                                                <td>{{ $ejemplar->cantidad_disponible }}</td>
                                                <td>
                                                   <button type="button" class="btn btn-info btn-sm">Botón</button>
                                                </td>
                                             </tr>
                                          @endforeach
                                       </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

   </div>
@stop

@section('js')
   <script>
        $(document).ready(function() {

            $('#tabla_de_productos_en_camino').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: "Compras en camino - "+new Date().toLocaleString(),
                        className: "bg-info",
                        exportOptions: {
                            columns: ':not(.no_exportar)'
                        }
                    }
                ],
            });

        });
   </script>
@stop