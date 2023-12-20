@extends('adminlte::page')

@section('title', 'Tarea')

@section('content_header')
    <h1>Vista de empleados y sus habilidades</h1>
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
                                    <th>Nombres</th>
                                    <th>Correo electrónico</th>
                                    <th>Rol</th>
                                    <th>Habilidades</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vw_empleados as $vw_empleado)
                                    <tr>
                                        <td>{{ $vw_empleado->Nombre_Empleado }}</td>
                                        <td>{{ $vw_empleado->Correo_Electronico }}</td>
                                        <td>{{ $vw_empleado->Rol }}</td>
                                        <td>{{ $vw_empleado->Habilidades }}</td>
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
