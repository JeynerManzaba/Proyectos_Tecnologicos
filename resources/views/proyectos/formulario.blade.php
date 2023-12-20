@extends('adminlte::page')

@section('title', isset($proyecto) ? 'Editar Proyecto' : 'Nuevo Proyecto')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>{{ isset($proyecto) ? 'Editar Proyecto' : 'Nuevo Proyecto' }}</h1>
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
                        @if(isset($proyecto))
                            {!! Form::model($proyecto, ['route' => ['proyectos.update', $proyecto->ID_Proyecto], 'method' => 'PUT']) !!}
                        @else
                            {!! Form::open(['route' => 'proyectos.store', 'method' => 'POST']) !!}
                        @endif
                            @csrf
                            <div class="form-group">
                                {!! Form::label('nombre', 'Nombre') !!}
                                {!! Form::text('nombre', isset($proyecto) ? $proyecto->Nombre : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('descripcion', 'Descripción') !!}
                                {!! Form::textarea('descripcion', isset($proyecto) ? $proyecto->Descripcion : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('fecha_inicio', 'Fecha de Inicio') !!}
                                {!! Form::date('fecha_inicio', isset($proyecto) ? $proyecto->Fecha_Inicio : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('fecha_fin', 'Fecha de Fin') !!}
                                {!! Form::date('fecha_fin', isset($proyecto) ? $proyecto->Fecha_Fin : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('estado', 'Estado') !!}
                                {!! Form::text('estado', isset($proyecto) ? $proyecto->Estado : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('id_cliente', 'Cliente') !!}
                                {!! Form::select('id_cliente', $clientes->pluck('Nombre', 'ID_Cliente'), isset($proyecto) ? $proyecto->ID_Cliente : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ isset($proyecto) ? 'Guardar Cambios' : 'Crear Proyecto' }}
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
