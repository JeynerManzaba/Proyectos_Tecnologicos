@extends('adminlte::page')

@section('title', 'Tarea')

@section('content_header')
    <h1>Vista de tareas asignadas a un empleado.</h1>
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
                                    <th>Tarea</th>
                                    <th>Estado</th>
                                    <th>Fecha de inicio</th>
                                    <th>Fecha de finalización</th>
                                    <th>Responsable</th>
                                    <th>Proyecto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vw_tareas as $vw_tarea)
                                    <tr>
                                        <td>{{ $vw_tarea->Descripcion_Tarea }}</td>
                                        <td>{{ $vw_tarea->Estado }}</td>
                                        <td>{{ $vw_tarea->Fecha_Inicio }}</td>
                                        <td>{{ $vw_tarea->Fecha_Fin }}</td>
                                        <td>{{ $vw_tarea->Responsable }}</td>
                                        <td>{{ $vw_tarea->Proyecto}}</td>
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
