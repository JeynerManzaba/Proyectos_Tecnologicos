@extends('adminlte::page')

@section('title', isset($empleado) ? 'Editar Empleado' : 'Nuevo Empleado')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>{{ isset($empleado) ? 'Editar Empleado' : 'Nuevo Empleado' }}</h1>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Inicio mensajes de error-->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <!-- Fin mensajes de error-->

                        <!-- Formulario de edición o creación -->
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
                        @if (isset($empleado))
                            {!! Form::model($empleado, ['route' => ['empleados.update', $empleado->ID_Empleado], 'method' => 'PUT']) !!}
                        @else
                            {!! Form::open(['route' => 'empleados.store', 'method' => 'POST']) !!}
                        @endif
                        @csrf
                        <div class="form-group">
                            {!! Form::label('nombre', 'Nombre') !!}
                            {!! Form::text('nombre', isset($empleado) ? $empleado->Nombre : null, ['class' => 'form-control', 'required']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('correo', 'Correo Electrónico') !!}
                            {!! Form::text('correo', old('correo', isset($empleado) ? $empleado->Correo_Electronico : null), [
                                'class' => 'form-control',
                                'required',
                            ]) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('rol_id', 'Rol') !!}
                            {!! Form::select('rol_id', $roles->pluck('Descripcion', 'ID_Rol'), isset($empleado) ? $empleado->rol_id : null, [
                                'class' => 'form-control',
                                'required',
                            ]) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('habilidades', 'Habilidades') !!}
                            <br>
                            @foreach ($habilidades as $habilidad)
                                <div class="form-check form-check-inline">
                                    {!! Form::checkbox(
                                        'habilidades[]',
                                        $habilidad->ID_Habilidad,
                                        isset($empleado) && $empleado->habilidades->contains($habilidad->ID_Habilidad),
                                        ['class' => 'form-check-input'],
                                    ) !!}
                                    {!! Form::label('habilidades[]', $habilidad->Descripcion, ['class' => 'form-check-label']) !!}
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary my-4">
                            {{ isset($empleado) ? 'Guardar Cambios' : 'Crear Empleado' }}
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
