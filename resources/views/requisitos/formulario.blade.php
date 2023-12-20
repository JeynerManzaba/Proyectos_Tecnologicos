@extends('adminlte::page')

@section('title', isset($requisito) ? 'Editar Requisito' : 'Nuevo Requisito')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>{{ isset($requisito) ? 'Editar Requisito' : 'Nuevo Requisito' }}</h1>
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
                        @if(isset($requisito))
                            {!! Form::model($requisito, ['route' => ['requisitos.update', $requisito->ID_Requisito], 'method' => 'PUT']) !!}
                        @else
                            {!! Form::open(['route' => 'requisitos.store', 'method' => 'POST']) !!}
                        @endif
                            @csrf
                            <div class="form-group">
                                {!! Form::label('descripcion', 'Descripción') !!}
                                {!! Form::text('descripcion', isset($requisito) ? $requisito->Descripcion : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('tipo', 'Tipo') !!}
                                {!! Form::select('tipo', ['Funcional' => 'Funcional', 'No Funcional' => 'No Funcional'], isset($requisito) ? $requisito->Tipo : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('id_proyecto', 'Proyecto') !!}
                                {!! Form::select('id_proyecto', $proyectos->pluck('Nombre', 'ID_Proyecto'), isset($requisito) ? $requisito->ID_Proyecto : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ isset($requisito) ? 'Guardar Cambios' : 'Crear Requisito' }}
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
