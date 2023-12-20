<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VistaController extends Controller
{
    public function vistaTareaEmpleado()
    {
        $vw_tareas = DB::table('vista_tareas_empleados')->get();
        return view('vistas.vw_tarea', compact('vw_tareas'));
    }

    public function vistaDetalleEmpleado ()
    {
        $vw_empleados = DB::table('vista_detalles_empleado')->get();
        return view('vistas.vw_empleado', compact('vw_empleados'));
    }

    public function vistaDetalleProyecto ()
    {
        $vw_proyectos = DB::table('vista_detalles_proyectos')->get();
        return view('vistas.vw_proyecto', compact('vw_proyectos'));
    }
}

