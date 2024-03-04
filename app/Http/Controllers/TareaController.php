<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tarea;
use App\Models\Empleado;
use App\Models\Proyecto;

class TareaController extends Controller
{
    public function index()
    {
        $tareas = Tarea::with(['empleado', 'proyecto'])->get();
        $empleados = Empleado::all();
        $proyectos = Proyecto::all();

        return view('tareas.index', compact('tareas', 'empleados', 'proyectos'));
    }

    public function create()
    {
        $empleados = Empleado::all();
        $proyectos = Proyecto::all();
        return view('tareas.formulario', compact('empleados', 'proyectos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
            'estado' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'ID_Empleado' => 'required',
            'ID_Proyecto' => 'required',
        ]);

        $descripcion = $request->input('descripcion');
        $estado = $request->input('estado');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $idEmpleado = $request->input('ID_Empleado');
        $idProyecto = $request->input('ID_Proyecto');

        DB::statement('exec CrearTarea ?, ?, ?, ?, ?, ?', [
            $descripcion, $estado, $fechaInicio, $fechaFin, $idEmpleado, $idProyecto
        ]);

        return redirect()->route('tareas.index')->with(['message' => 'Tarea creada satisfactoriamente', 'type' => 'success']);
    }

    public function edit($ID_Tarea)
    {
        $tarea = Tarea::with(['empleado', 'proyecto'])->find($ID_Tarea);
        $empleados = Empleado::all();
        $proyectos = Proyecto::all();
        return view('tareas.formulario', compact('tarea', 'empleados', 'proyectos'));
    }

    public function update(Request $request, $ID_Tarea)
    {
        $request->validate([
            'descripcion' => 'required',
            'estado' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'ID_Empleado' => 'required',
            'ID_Proyecto' => 'required',
        ]);

        $descripcion = $request->input('descripcion');
        $estado = $request->input('estado');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $idEmpleado = $request->input('ID_Empleado');
        $idProyecto = $request->input('ID_Proyecto');

        DB::statement('exec ActualizarTarea ?, ?, ?, ?, ?, ?, ?', [
            $ID_Tarea, $descripcion, $estado, $fechaInicio, $fechaFin, $idEmpleado, $idProyecto
        ]);

        return redirect()->route('tareas.index')->with(['message' => 'Tarea actualizada satisfactoriamente', 'type' => 'success']);
    }

    public function destroy($ID_Tarea)
    {
        DB::statement('exec EliminarTarea ? ', [$ID_Tarea]);

        return redirect()->route('tareas.index')->with(['message' => 'Tarea eliminada satisfactoriamente', 'type' => 'success']);
    }
}
