@extends('adminlte::page')

@section('title', isset($marca) ? 'Editar Marca de Auto' : 'Nueva Marca de Auto')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>{{ isset($marca) ? 'Editar Marca de Auto' : 'Nueva Marca de Auto' }}</h1>
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
                        @if(isset($marca))
                            {!! Form::model($marca, ['route' => ['marcas.update', $marca->ID_Marca], 'method' => 'PUT']) !!}
                        @else
                            {!! Form::open(['route' => 'marcas.store', 'method' => 'POST']) !!}
                        @endif
                            @csrf
                            <div class="form-group">
                                {!! Form::label('nombre', 'Nombre de la Marca') !!}
                                {!! Form::text('nombre', isset($marca) ? $marca->Nombre : null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ isset($marca) ? 'Guardar Cambios' : 'Crear Marca de Auto' }}
                            </button>

                            @if(isset($marca))
                                <!-- Botón de Eliminar con Confirmación -->
                                <button type="button" class="btn btn-danger" onclick="confirmarEliminar()">
                                    Eliminar Marca
                                </button>

                                <!-- Modal de Confirmación de Eliminación -->
                                <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirmar Eliminación</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Estás seguro de que deseas eliminar esta marca de auto?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <button type="button" class="btn btn-danger" onclick="eliminarMarca()">Eliminar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        {!! Form::close() !!}
                        <!-- Fin del formulario de edición o creación -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmarEliminar() {
            $('#deleteConfirmationModal').modal('show');
        }
        function eliminarMarca() {
            alert('Aquí deberías enviar el formulario de eliminación');
            $('#deleteConfirmationModal').modal('hide');
        }
    </script>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop
