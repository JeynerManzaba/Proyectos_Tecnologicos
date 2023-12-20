@extends('adminlte::page')

@section('title', 'vistas')

@section('content_header')
    <h1>Vista de proyectos y requisitos del cliente</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                   <!-- <div class="card-header">
                        <h4>Vista de tareas asignadas a un empleado.</h4>
                    </div>  -->
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if (session('message') && session('type') == 'success')
                            <div class="alert alert-{{ session('type') }} alert-dismissible fade show" role="alert">
                                <p>{{ session('message') }}</p>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @php session()->forget([ 'message', 'type' ]); @endphp
                        @endif
                        <table id="dataTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre del proyecto</th>
                                    <th>Estado</th>
                                    <th>Nombre del cliente</th>
                                    <th>Tipo de requisito</th>
                                    <th>Detalle del requisito</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vw_proyectos as $vw_proyecto)
                                    <tr>
                                        <td>{{ $vw_proyecto->Nombre_Proyecto }}</td>
                                        <td>{{ $vw_proyecto->Estado }}</td>
                                        <td>{{ $vw_proyecto->Nombre_Cliente }}</td>
                                        <td>{{ $vw_proyecto->Tipo_Requisito }}</td>
                                        <td>{{ $vw_proyecto->Requisito_Cliente }}</td>
                                    </tr>
                                @endforeach
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $('#dataTable').dataTable();
    </script>
@stop
