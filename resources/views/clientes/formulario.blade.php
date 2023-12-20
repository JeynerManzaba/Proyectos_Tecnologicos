@extends('adminlte::page')

@section('title', isset($cliente) ? 'Editar Cliente' : 'Nuevo Cliente')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>{{ isset($cliente) ? 'Editar Cliente' : 'Nuevo Cliente' }}</h1>
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
                        @if(isset($cliente))
                            {!! Form::model($cliente, ['route' => ['clientes.update', $cliente->ID_Cliente], 'method' => 'PUT']) !!}
                        @else
                            {!! Form::open(['route' => 'clientes.store', 'method' => 'POST']) !!}
                        @endif
                            @csrf
                            <div class="form-group">
                                {!! Form::label('nombre', 'Nombre') !!}
                                {!! Form::text('nombre', isset($cliente) ? $cliente->Nombre : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('cedula', 'Cédula') !!}
                                {!! Form::text('cedula', isset($cliente) ? $cliente->Cedula : null, ['class' => 'form-control', 'required', 'pattern' => '^\d{10}$', 'maxlength' => 10]) !!}
                                <small class="form-text text-muted">Ejemplo: 0503929267</small>
                            </div>

                            <div class="form-group">
                                {!! Form::label('telefono', 'Teléfono') !!}
                                {!! Form::text('telefono', isset($cliente) ? $cliente->Telefono : null, ['class' => 'form-control', 'required', 'pattern' => '^\d{10}$', 'maxlength' => 10]) !!}
                                <small class="form-text text-muted">Solo números permitidos</small>
                            </div>

                            <div class="form-group">
                                {!! Form::label('correo', 'Correo Electrónico') !!}
                                {!! Form::email('correo', isset($cliente) ? $cliente->Correo_Electronico : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ isset($cliente) ? 'Guardar Cambios' : 'Crear Cliente' }}
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
