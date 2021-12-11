@extends('adminlte::page')

@section('title', 'Ventas')

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
                                    <h1 class="text-center m-2">Ventas Finalizadas</h1>
                                    <table id="tabla_de_ventas_finalizadas" class="table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>N°</th>
                                                <th>ID</th>
                                                <th>Productos</th>
                                                <th>Precio Venta</th>
                                                <th>Precio Costo</th>
                                                <th>Ganancia</th>
                                                <th>Fecha</th>
                                                <th class="no_exportar">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- SERVER SIDE PROCESSING --}}
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

            $('#tabla_de_ventas_finalizadas').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: "Ventas Finalizadas - "+new Date().toLocaleString(),
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