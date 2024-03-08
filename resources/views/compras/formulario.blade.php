@extends('adminlte::page')

@section('title', isset($compra) ? 'Editar Compra' : 'Nueva Compra')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>{{ isset($compra) ? 'Editar Compra' : 'Nueva Compra' }}</h1>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
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

                        <!-- Formulario de edición o creación -->
                        @if(isset($compra))
                            {!! Form::model($compra, ['route' => ['compras.update', $compra->ID_Compra], 'method' => 'PUT']) !!}
                        @else
                            {!! Form::open(['route' => 'compras.store', 'method' => 'POST']) !!}
                        @endif
                            @csrf
                            <div class="form-group">
                                {!! Form::label('ID_Auto', 'Auto') !!}
                                {!! Form::select('ID_Auto', $autos->pluck('Modelo', 'ID_Auto'), isset($compra) ? $compra->auto->ID_Auto : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('ID_Cliente', 'Cliente') !!}
                                {!! Form::select('ID_Cliente', $clientes->pluck('Nombre', 'ID_Cliente'), isset($compra) ? $compra->cliente->ID_Cliente : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('FechaCompra', 'Fecha de Compra') !!}
                                {!! Form::date('FechaCompra', isset($compra) ? $compra->FechaCompra : now(), ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('CantidadComprada', 'Cantidad Comprada') !!}
                                {!! Form::number('CantidadComprada', isset($compra) ? $compra->CantidadComprada : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ isset($compra) ? 'Guardar Cambios' : 'Crear Compra' }}
                            </button>
                        {!! Form::close() !!}
                        <!-- Fin del formulario de edición o creación -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop
