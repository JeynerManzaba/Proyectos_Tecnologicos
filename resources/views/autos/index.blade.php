@extends('adminlte::page')

@section('title', 'Autos')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Autos</h1>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('autos.create') }}" class="btn btn-primary btn-sm" style="font-size: 14px">
                            Nuevo Auto
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
                                    <th>Modelo</th>
                                    <th>Año</th>
                                    <th>Precio</th>
                                    <th>Marca</th>
                                    <th>Stock</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($autos as $auto)
                                    <tr>
                                        <td>{{ $auto->Modelo }}</td>
                                        <td>{{ $auto->Año }}</td>
                                        <td>{{ $auto->Precio }}</td>
                                        <td>{{ $auto->marca->Nombre }}</td>
                                        <td>{{ $auto->Stock }}</td>
                                        <td>
                                            <div class="d-flex justify-content-around">
                                                <a href="{{ route('autos.edit', $auto->ID_Auto) }}"
                                                    class="btn btn-primary btn-sm mr-3">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#deleteModal{{ $auto->ID_Auto }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <!-- Modal para confirmar la eliminación -->
                                                <div class="modal fade" id="deleteModal{{ $auto->ID_Auto }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="deleteModalLabel{{ $auto->ID_Auto }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="deleteModalLabel{{ $auto->ID_Auto }}">
                                                                    Confirmar Eliminación</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Estás seguro de que deseas eliminar este auto?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                {!! Form::open(['route' => ['autos.destroy', $auto->ID_Auto], 'method' => 'DELETE']) !!}
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
