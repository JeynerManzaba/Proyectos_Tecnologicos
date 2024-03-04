@extends('adminlte::page')

@section('title', isset($tiendaAuto) ? 'Editar TiendaAuto' : 'Nueva TiendaAuto')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>{{ isset($tiendaAuto) ? 'Editar TiendaAuto' : 'Nueva TiendaAuto' }}</h1>
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
                        @if(isset($tiendaAuto))
                            {!! Form::model($tiendaAuto, ['route' => ['tiendaAutos.update', $tiendaAuto->ID_TiendaAuto], 'method' => 'PUT']) !!}
                        @else
                            {!! Form::open(['route' => 'tiendaAutos.store', 'method' => 'POST']) !!}
                        @endif
                            @csrf
                            <div class="form-group">
                                {!! Form::label('nombre_tienda', 'Nombre Tienda') !!}
                                {!! Form::text('nombre_tienda', isset($tiendaAuto) ? $tiendaAuto->Nombre_Tienda : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <!-- Agrega los demás campos según tu estructura de la tabla TiendaAutos -->

                            <button type="submit" class="btn btn-primary">
                                {{ isset($tiendaAuto) ? 'Guardar Cambios' : 'Crear TiendaAuto' }}
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
