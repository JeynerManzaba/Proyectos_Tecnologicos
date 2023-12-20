<!-- En tu formulario.blade.php para Tareas -->

@extends('adminlte::page')

@section('title', isset($tarea) ? 'Editar Tarea' : 'Nueva Tarea')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>{{ isset($tarea) ? 'Editar Tarea' : 'Nueva Tarea' }}</h1>
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
                        @if(isset($tarea))
                            {!! Form::model($tarea, ['route' => ['tareas.update', $tarea->ID_Tarea], 'method' => 'PUT']) !!}
                        @else
                            {!! Form::open(['route' => 'tareas.store', 'method' => 'POST']) !!}
                        @endif
                            @csrf
                            <div class="form-group">
                                {!! Form::label('descripcion', 'Descripción') !!}
                                {!! Form::text('descripcion', isset($tarea) ? $tarea->Descripcion : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('estado', 'Estado') !!}
                                {!! Form::text('estado', isset($tarea) ? $tarea->Estado : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('fecha_inicio', 'Fecha de Inicio') !!}
                                {!! Form::date('fecha_inicio', isset($tarea) ? $tarea->Fecha_Inicio : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('fecha_fin', 'Fecha de Fin') !!}
                                {!! Form::date('fecha_fin', isset($tarea) ? $tarea->Fecha_Fin : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('ID_Empleado', 'Empleado') !!}
                                {!! Form::select('ID_Empleado', $empleados->pluck('Nombre', 'ID_Empleado'), isset($tarea) ? $tarea->ID_Empleado : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('ID_Proyecto', 'Proyecto') !!}
                                {!! Form::select('ID_Proyecto', $proyectos->pluck('Nombre', 'ID_Proyecto'), isset($tarea) ? $tarea->ID_Proyecto : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ isset($tarea) ? 'Guardar Cambios' : 'Crear Tarea' }}
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
