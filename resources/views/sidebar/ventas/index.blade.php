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
                                    <h1 class="text-center m-2">Ventas pendientes</h1>
                                    <table id="tabla_de_ventas_pendientes" class="table-hover" style="width:100%">
                                       <thead>
                                          <tr>
                                             <th>N°</th>
                                             <th>ID</th>
                                             <th>Cantidad</th>
                                             <th>Producto</th>
                                             <th>Precio Total</th>
                                             <th>Fecha de Compra</th>
                                             <th>Status</th>
                                             <th class="no_exportar">Acciones</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <tr></tr>
                                       </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h1 class="text-center m-2">Ventas Culminadas</h1>
                                    <table id="tabla_de_ventas_culminadas" class="table-hover" style="width:100%">
                                       <thead>
                                          <tr>
                                             <th>N°</th>
                                             <th>ID</th>
                                             <th>Cantidad</th>
                                             <th>Producto</th>
                                             <th>Precio Total</th>
                                             <th>Fecha de Compra</th>
                                             <th>Status</th>
                                             <th class="no_exportar">Acciones</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <tr></tr>
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

            $('#tabla_de_ventas_pendientes').DataTable({
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

            $('#tabla_de_ventas_culminadas').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: "Compras recibidas - "+new Date().toLocaleString(),
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