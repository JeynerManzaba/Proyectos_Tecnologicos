<?php

use App\Models\Requisito;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\VistaController;
use App\Http\Controllers\HabilidadController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\AutoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\CompraAutoController;


//Rutas por defecto
Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', function() {return view('home');})->name('auth.home')->middleware('auth');



//Rutas (SP_Crud)
Route::middleware('auth')->group(function () {
    Route::resource('clientes', ClienteController::class);
    Route::resource('roles', RolController::class);
    Route::resource('habilidades', HabilidadController::class);
    Route::resource('empleados', EmpleadoController::class);
    Route::resource('proyectos', ProyectoController::class);
    Route::resource('tareas', TareaController::class);
    Route::resource('autos', AutoController::class);
    Route::resource('marcas', MarcaController::class);
    Route::resource('tiendas', TiendaController::class);
    Route::resource('compras', CompraAutoController::class);


});

//Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');

// Rutas para las vistas SQL
Route::get('/vw_tarea', [VistaController::class, 'vistaTareaEmpleado'])->name('vistas.vw_tarea');
Route::get('/vw_empleado', [VistaController::class, 'vistaDetalleEmpleado'])->name('vistas.vw_empleado');
Route::get('/vw_proyecto', [VistaController::class, 'vistaDetalleProyecto'])->name('vistas.vw_proyecto');
