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
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('ajax.get_finished_sales') }}"
                },
                columns: [
                    { data: "id", name: 'id'},
                    { data: "productos", name: 'productos'},
                    { data: "final_amount", name: 'final_amount'},
                    { data: "final_cost", name: 'final_cost'},
                    { data: "final_profit", name: 'final_profit'},
                    { data: "fecha", name: 'fecha'},
                    { data: 'action', orderable: false, searchable:     false, },

                    // { data: "talleres"},
                    // { data: "icon", orderable: false, searchable: false,
                    //     render: function (data, type, row){
                    //         return `<img width="50" class="img-fluid" src="${data}" alt="Icono de la destreza">`;
                    //     },
                    // },
                    
                ],
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