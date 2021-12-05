@extends('adminlte::page')

@section('title', 'Productos')

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
                                    <h1 class="text-center m-2">Nombre de la Entidad: {{ $entity->name }}</h1>
                                    @if ( count($entity->attributes) > 0 )
                                        @foreach ($entity->attributes as $attr)
                                            <select name="{{ $attr->name }}" id="">
                                                 
                                            </select>
                                            <span>{{ $attr->name }} - {{ $attr->value }}</span>
                                        @endforeach
                                    @endif
                                    <table id="productos" class="table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>N°</th>
                                                <th>Atributos</th>
                                                <th class="no_exportar">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($entity->attributes as $attr)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        @if ( count($product->attributes) > 0 )
                                                            @foreach ($product->attributes as $attr)
                                                                <span>{{ $attr->name }} - {{ $attr->value }}</span>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm">Ver</button>
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

            $('#productos').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    title: "Productos disponibles - " + new Date().toLocaleString(),
                    className: "bg-info",
                    exportOptions: {
                        columns: ':not(.no_exportar)'
                    }
                }],
            });

        });
    </script>
@stop
