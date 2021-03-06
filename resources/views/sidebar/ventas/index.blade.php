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
                        <div class="card-body" style="overflow-x:auto;">
                            <h1 class="h5 text-center"><b>BÚSQUEDA AVANZADA</b></h1>
                            <table style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center px-2">&nbsp;</th>
                                        <th class="text-center px-2">Precio Venta</th>
                                        <th class="text-center px-2">Precio Costo</th>
                                        <th class="text-center px-2">Ganancia</th>
                                        <th class="text-center px-2">Fecha</th>
                                        <th class="text-center px-2">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="px-2">&nbsp;</td>
                                        <td class="px-2"><input id="input__precio_venta" class="form-control input-border-radius" type="number"></td>
                                        <td class="px-2"><input id="input__precio_costo" class="form-control input-border-radius" type="number"></td>
                                        <td class="px-2"><input id="input__precio_ganancia" class="form-control input-border-radius" type="number"></td>

                                        <td class="px-2">
                                            <select id="input__mes" class="form-control">
                                                <option selected disabled>Mes</option>
                                                <option value="">Todos</option>
                                                <option value="1">Enero</option>
                                                <option value="2">Febrero</option>
                                                <option value="3">Marzo</option>
                                                <option value="4">Abril</option>
                                                <option value="5">Mayo</option>
                                                <option value="6">Junio</option>
                                                <option value="7">Julio</option>
                                                <option value="8">Agosto</option>
                                                <option value="9">Septiembre</option>
                                                <option value="10">Octubre</option>
                                                <option value="11">Noviembre</option>
                                                <option value="12">Diciembre</option>
                                            </select>
                                        </td>
                                        <td class="px-2">
                                            <select name="date" id="input__anio" class="form-control">
                                                <option selected disabled>Año</option>
                                                <option value="">Todos</option>
                                                <option value="{{ date("Y") }}">{{ date("Y") }}</option>
                                                <option value="{{ date("Y") - 1 }}">{{ date("Y") - 1 }}</option>
                                                <option value="{{ date("Y") - 2 }}">{{ date("Y") - 2 }}</option>
                                                <option value="{{ date("Y") - 3 }}">{{ date("Y") - 3 }}</option>
                                                <option value="{{ date("Y") - 4 }}">{{ date("Y") - 4 }}</option>
                                                <option value="{{ date("Y") - 5 }}">{{ date("Y") - 5 }}</option>
                                                <option value="{{ date("Y") - 6 }}">{{ date("Y") - 6 }}</option>
                                                <option value="{{ date("Y") - 7 }}">{{ date("Y") - 7 }}</option>
                                                <option value="{{ date("Y") - 8 }}">{{ date("Y") - 8 }}</option>
                                                <option value="{{ date("Y") - 9 }}">{{ date("Y") - 9 }}</option>
                                                <option value="{{ date("Y") - 10 }}">{{ date("Y") - 10 }}</option>
                            
                                            </select>
                                        </td>
    
                                        <td class="px-2"><button onclick="ir_a_buscar()" class="btn btn-sm btn-success" type="button">Buscar</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

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
                                                <th>Venta</th>
                                                <th>Total Venta</th>
                                                <th>Costo</th>
                                                <th>Total Costo</th>
                                                <th>Ganancia</th>
                                                <th>Total Ganancia</th>
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
       let TABLA_DE_VENTAS;
        $(document).ready(function() {

            TABLA_DE_VENTAS = $('#tabla_de_ventas_finalizadas').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('ajax.get_finished_sales') }}",
                    data: function ( d ) {
                        d.search_by_final_amount = $('#input__precio_venta').val();
                        d.search_by_final_cost   = $('#input__precio_costo').val();
                        d.search_by_final_profit = $('#input__precio_ganancia').val();
                        d.search_by_month        = $('#input__mes').val();
                        d.search_by_anio         = $('#input__anio').val();
                    }
                },
                columns: [
                    { data: "id",             },
                    { data: "productos",      },
                    { data: "final_amount",   },
                    { data: "total_venta",    
                        render: function (data, type, row){
                            return `<b>${data}</b>`;
                        },
                    },
                    { data: "final_cost",     },
                    { data: "total_costo",    
                        render: function (data, type, row){
                            return `<b>${data}</b>`;
                        },
                    },
                    { data: "final_profit",   },
                    { data: "total_ganancia", 
                        render: function (data, type, row){
                            return `<b>${data}</b>`;
                        },
                    },
                    { data: "fecha",          },
                    { data: 'action', orderable: false, searchable:false, },                    
                ],
                pageLength: 30,
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
                        },
                        action: newExportAction
                    }
                ],
            });

            // función para exportar el excel con todas las filas
            function newExportAction(e, dt, button, config) {
                var self = this;
                var oldStart = dt.settings()[0]._iDisplayStart;
                dt.one('preXhr', function (e, s, data) {
                    // Just this once, load all data from the server...
                    data.start = 0;
                    data.length = 2147483647;
                    dt.one('preDraw', function (e, settings) {
                        // Call the original action function
                        if (button[0].className.indexOf('buttons-copy') >= 0) {
                            $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                        } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                            $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                                $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                                $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                        } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                            $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                                $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                                $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                        } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                            $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                                $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                                $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                        } else if (button[0].className.indexOf('buttons-print') >= 0) {
                            $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                        }
                        dt.one('preXhr', function (e, s, data) {
                            // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                            // Set the property to what it was before exporting.
                            settings._iDisplayStart = oldStart;
                            data.start = oldStart;
                        });
                        // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                        setTimeout(dt.ajax.reload, 0);
                        // Prevent rendering of the full data to the DOM
                        return false;
                    });
                });
                // Requery the server with the new one-time export settings
                dt.ajax.reload();
            }

        });

        function ir_a_buscar(){
            TABLA_DE_VENTAS.draw();
        }

        // Pintar en verde los inputs que contienen algo
        $( "#input__precio_venta" ).change(function() { agregar_quitar_bg_success('input__precio_venta'); });
        $( "#input__precio_costo" ).change(function() { agregar_quitar_bg_success('input__precio_costo'); });
        $( "#input__precio_ganancia" ).change(function() { agregar_quitar_bg_success('input__precio_ganancia'); });
        $( "#input__mes" ).change(function() { agregar_quitar_bg_success('input__mes'); });
        $( "#input__anio" ).change(function() { agregar_quitar_bg_success('input__anio'); });

        function agregar_quitar_bg_success(id){
            if ( $(`#${id}`).val() !== "" ) {
                $(`#${id}`).addClass('bg-success');
            } else {
                $(`#${id}`).removeClass('bg-success');
            }
        }
   </script>
@stop