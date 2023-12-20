@extends('adminlte::page')

@section('title', isset($habilidad) ? 'Editar Habilidad' : 'Nueva Habilidad')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>{{ isset($habilidad) ? 'Editar Habilidad' : 'Nueva Habilidad' }}</h1>
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
                        @if(isset($habilidad))
                            {!! Form::model($habilidad, ['route' => ['habilidades.update', $habilidad->ID_Habilidad], 'method' => 'PUT']) !!}
                        @else
                            {!! Form::open(['route' => 'habilidades.store', 'method' => 'POST']) !!}
                        @endif
                            @csrf
                            <div class="form-group">
                                {!! Form::label('descripcion', 'Descripción') !!}
                                {!! Form::text('descripcion', isset($habilidad) ? $habilidad->Descripcion : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('nivel_dificultad', 'Nivel de Dificultad') !!}
                                {!! Form::number('nivel_dificultad', isset($habilidad) ? $habilidad->Nivel_Dificultad : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ isset($habilidad) ? 'Guardar Cambios' : 'Crear Habilidad' }}
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
