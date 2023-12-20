<!-- resources/views/roles/formulario.blade.php -->

@extends('adminlte::page')

@section('title', isset($rol) ? 'Editar Rol' : 'Nuevo Rol')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>{{ isset($rol) ? 'Editar Rol' : 'Nuevo Rol' }}</h1>
    </div>
@stop

@section('content')
    <div class="container-fluid text-lg">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body" style=" font-size: 18px;">
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
                        @if(isset($rol))
                            {!! Form::model($rol, ['route' => ['roles.update', $rol->ID_Rol], 'method' => 'PUT']) !!}
                        @else
                            {!! Form::open(['route' => 'roles.store', 'method' => 'POST']) !!}
                        @endif
                            @csrf
                            <div class="form-group">
                                {!! Form::label('descripcion', 'Descripción') !!}
                                {!! Form::text('descripcion', isset($rol) ? $rol->Descripcion : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <button type="submit" class="btn btn-primary ">
                                {{ isset($rol) ? 'Guardar Cambios' : 'Crear Rol' }}
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
