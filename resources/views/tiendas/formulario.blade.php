@extends('adminlte::page')

@section('title', isset($tienda) ? 'Editar Tienda' : 'Nueva Tienda')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>{{ isset($tienda) ? 'Editar Tienda' : 'Nueva Tienda' }}</h1>
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
                        @if(isset($tienda))
                            {!! Form::model($tienda, ['route' => ['tiendas.update', $tienda->ID_Tienda], 'method' => 'PUT']) !!}
                        @else
                            {!! Form::open(['route' => 'tiendas.store', 'method' => 'POST']) !!}
                        @endif
                            @csrf
                            <div class="form-group">
                                {!! Form::label('nombre', 'Nombre') !!}
                                {!! Form::text('nombre', isset($tienda) ? $tienda->Nombre : null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('direccion', 'Direccion') !!}
                                {!! Form::text('direccion', isset($tienda) ? $tienda->Direccion : null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <button type="submit" class="btn btn-primary">
                                {{ isset($tienda) ? 'Guardar Cambios' : 'Crear Tienda' }}
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
