@extends('adminlte::page')

@section('title', isset($marcaAuto) ? 'Editar Marca de Auto' : 'Nueva Marca de Auto')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>{{ isset($marcaAuto) ? 'Editar Marca de Auto' : 'Nueva Marca de Auto' }}</h1>
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
                        @if(isset($marcaAuto))
                            {!! Form::model($marcaAuto, ['route' => ['marcasautos.update', $marcaAuto->ID_Marca], 'method' => 'PUT']) !!}
                        @else
                            {!! Form::open(['route' => 'marcasautos.store', 'method' => 'POST']) !!}
                        @endif
                            @csrf
                            <div class="form-group">
                                {!! Form::label('nombre', 'Nombre de la Marca') !!}
                                {!! Form::text('nombre', isset($marcaAuto) ? $marcaAuto->Nombre : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ isset($marcaAuto) ? 'Guardar Cambios' : 'Crear Marca de Auto' }}
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
