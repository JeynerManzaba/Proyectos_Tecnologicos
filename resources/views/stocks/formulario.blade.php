@extends('adminlte::page')

@section('title', isset($stock) ? 'Editar Stock' : 'Nuevo Stock')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>{{ isset($stock) ? 'Editar Stock' : 'Nuevo Stock' }}</h1>
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
                        @if(isset($stock))
                            {!! Form::model($stock, ['route' => ['stocks.update', $stock->ID_Stock], 'method' => 'PUT']) !!}
                        @else
                            {!! Form::open(['route' => 'stocks.store', 'method' => 'POST']) !!}
                        @endif
                            @csrf
                            <div class="form-group">
                                {!! Form::label('id_tienda', 'Tienda') !!}
                                {!! Form::select('id_tienda', $tiendas->pluck('Nombre', 'ID_Tienda'), isset($stock) ? $stock->ID_Tienda : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('id_auto', 'Auto') !!}
                                {!! Form::select('id_auto', $autos->pluck('Modelo', 'ID_Auto'), isset($stock) ? $stock->ID_Auto : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('cantidad_en_stock', 'Cantidad en Stock') !!}
                                {!! Form::number('cantidad_en_stock', isset($stock) ? $stock->CantidadEnStock : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ isset($stock) ? 'Guardar Cambios' : 'Crear Stock' }}
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
