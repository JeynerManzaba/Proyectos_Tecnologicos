@extends('adminlte::page')

@section('title', 'Lista de Compras')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Lista de Compras</h1>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('compras.create') }}" class="btn btn-primary btn-sm" style="font-size: 14px">
                            Nueva Compra
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
                                    <th>Auto</th>
                                    <th>Cliente</th>
                                    <th>Fecha de Compra</th>
                                    <th>Cantidad</th>
                                    <th>Precio Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($compras as $compra)
                                    <tr>
                                        <td>{{ $compra->auto->Modelo }}</td>
                                        <td>{{ $compra->cliente->Nombre }}</td>
                                        <td>{{ $compra->FechaCompra }}</td>
                                        <td>{{ $compra->CantidadComprada }}</td>
                                        <td>{{ $compra->PrecioTotal }}</td>
                                        <td>
                                            <div class="d-flex justify-content-around">

                                                <a href="{{ route('compras.edit', $compra->ID_Compra) }}"
                                                    class="btn btn-primary btn-sm">
                                                    Editar
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#deleteModal{{ $compra->ID_Compra }}">
                                                    Eliminar
                                                </button>
                                                <!-- Modal para confirmar la eliminación -->
                                                <div class="modal fade" id="deleteModal{{ $compra->ID_Compra }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="deleteModalLabel{{ $compra->ID_Compra }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="deleteModalLabel{{ $compra->ID_Compra }}">
                                                                    Confirmar Eliminación</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Estás seguro de que deseas eliminar esta compra?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                {!! Form::open(['route' => ['compras.destroy', $compra->ID_Compra], 'method' => 'DELETE']) !!}
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
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@stop
