<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Proyecto;
use App\Models\Cliente;

class ProyectoController extends Controller
{
    public function index()
    {
        $proyectos = Proyecto::with('cliente')->get();
        return view('proyectos.index', compact('proyectos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        return view('proyectos.formulario', compact('clientes'));
    }

    public function store(Request $request)
    {
        // Obtén el ID del cliente seleccionado
        $nombre = $request->input('nombre');
        $descripcion = $request->input('descripcion');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $estado = $request->input('estado');
        $idCliente = $request->input('id_cliente');

        DB::statement('CALL CrearProyecto(?, ?, ?, ?, ?, ?)', [$nombre, $descripcion, $fechaInicio, $fechaFin, $estado, $idCliente]);

        return redirect()->route('proyectos.index')->with(['message' => 'Proyecto creado satisfactoriamente', 'type' => 'success']);
    }

    public function edit($ID_Proyecto)
    {
        $proyecto = Proyecto::with('cliente')->find($ID_Proyecto);
        $clientes = Cliente::all();
        return view('proyectos.formulario', compact('proyecto', 'clientes'));
    }

    public function update(Request $request, int $ID_Proyecto)
    {
        $nombre = $request->input('nombre');
        $descripcion = $request->input('descripcion');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $estado = $request->input('estado');
        $idCliente = $request->input('id_cliente');

        DB::statement('CALL ActualizarProyecto(?, ?, ?, ?, ?, ?, ?)', [$ID_Proyecto, $nombre, $descripcion, $fechaInicio, $fechaFin, $estado, $idCliente]);

        return redirect()->route('proyectos.index')->with(['message' => 'Proyecto actualizado satisfactoriamente', 'type' => 'success']);
    }

    public function destroy($ID_Proyecto)
    {
        DB::statement('CALL EliminarProyecto(?)', [$ID_Proyecto]);

        return redirect()->route('proyectos.index')->with(['message' => 'Proyecto eliminado satisfactoriamente', 'type' => 'success']);
    }
}
