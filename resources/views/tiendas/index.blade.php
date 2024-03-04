@extends('adminlte::page')

@section('title', 'TiendaAutos')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>TiendaAutos</h1>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('tiendaAutos.create') }}" class="btn btn-primary btn-sm" style="font-size: 16px">
                            Nueva TiendaAuto
                        </a>
                    </div>
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
                                    <th>Nombre Tienda</th>
                                    <!-- Agrega los demás encabezados según tu estructura de la tabla TiendaAutos -->
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tiendaAutos as $tiendaAuto)
                                    <tr>
                                        <td>{{ $tiendaAuto->Nombre_Tienda }}</td>
                                        <!-- Agrega los demás campos según tu estructura de la tabla TiendaAutos -->
                                        <td>
                                            <div class="d-flex justify-content-around">
                                                <a href="{{ route('tiendaAutos.edit', $tiendaAuto->ID_TiendaAuto) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#deleteModal{{ $tiendaAuto->ID_TiendaAuto }}">
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </button>
                                                <!-- Modal para confirmar la eliminación -->
                                                <div class="modal fade" id="deleteModal{{ $tiendaAuto->ID_TiendaAuto }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="deleteModalLabel{{ $tiendaAuto->ID_TiendaAuto }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="deleteModalLabel{{ $tiendaAuto->ID_TiendaAuto }}">
                                                                    Confirmar Eliminación</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Estás seguro de que deseas eliminar esta TiendaAuto?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                {!! Form::open(['route' => ['tiendaAutos.destroy', $tiendaAuto->ID_TiendaAuto], 'method' => 'DELETE']) !!}
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
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
