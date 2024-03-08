@extends('adminlte::page')

@section('title', isset($auto) ? 'Editar Auto' : 'Nuevo Auto')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>{{ isset($auto) ? 'Editar Auto' : 'Nuevo Auto' }}</h1>
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
                        @if(isset($auto))
                            {!! Form::model($auto, ['route' => ['autos.update', $auto->ID_Auto], 'method' => 'PUT']) !!}
                        @else
                            {!! Form::open(['route' => 'autos.store', 'method' => 'POST']) !!}
                        @endif
                            @csrf
                            <div class="form-group">
                                {!! Form::label('modelo', 'Modelo') !!}
                                {!! Form::text('modelo', isset($auto) ? $auto->Modelo : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('ano', 'Año') !!}
                                {!! Form::number('ano', isset($auto) ? $auto->Año : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('precio', 'Precio') !!}
                                {!! Form::text('precio', isset($auto) ? $auto->Precio : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('id_marca', 'Marca') !!}
                                {!! Form::select('id_marca', $marcas->pluck('Nombre', 'ID_Marca'), isset($auto) ? $auto->ID_Marca : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('stock', 'Stock') !!}
                                {!! Form::number('stock', isset($auto) ? $auto->Stock : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('id_tienda', 'Tienda') !!}
                                {!! Form::select('id_tienda', $tiendas->pluck('Nombre', 'ID_Tienda'), isset($auto) ? $auto->ID_Tienda : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ isset($auto) ? 'Guardar Cambios' : 'Crear Auto' }}
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
