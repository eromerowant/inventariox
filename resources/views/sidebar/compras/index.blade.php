@extends('adminlte::page')

@section('title', 'Compras')

@section('css')
@stop

@section('content')
   <div id="appVue">

        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h1 class="text-center m-2">Listado de Talleres</h1>
                    <table id="tabla_de_compras" class="table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cantidad</th>
                                <th>Precio Total</th>
                                <th>Status</th>
                                <th class="no_exportar">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($compras as $compra)
                                <tr>
                                    <td>{{ $compra->id }}</td>
                                    <td>{{ $compra->cantidad }}</td>
                                    <td>{{ number_format($compra->precio_total, 2, ',', '.') }}</td>
                                    <td>{{ $compra->status == 1 ? "En camino" : "Recibida" }}</td>
                                    <td>
                                        <button class="btn btn-outline-info btn-sm">Botón</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

   </div>
@stop

@section('js')
   <script>
        $(document).ready(function() {

            $('#tabla_de_compras').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: "Listado de Compras - "+new Date().toLocaleString(),
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