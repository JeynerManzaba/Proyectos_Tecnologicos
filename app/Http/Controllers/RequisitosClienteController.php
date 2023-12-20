<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RequisitosCliente;
use App\Models\Proyecto;

class RequisitosClienteController extends Controller
{
    public function index()
    {
        $requisitos = RequisitosCliente::with('proyecto')->get();
        return view('requisitos.index', compact('requisitos'));
    }

    public function create()
    {
        $proyectos = Proyecto::all();
        return view('requisitos.formulario', compact('proyectos'));
    }

    public function store(Request $request)
    {
        $descripcion = $request->input('descripcion');
        $tipo = $request->input('tipo');
        $idProyecto = $request->input('id_proyecto');

        DB::statement('CALL CrearRequisitoCliente(?, ?, ?)', [$descripcion, $tipo, $idProyecto]);
        return redirect()->route('requisitos.index')->with(['message' => 'Requisito creado satisfactoriamente', 'type' => 'success']);
    }

    public function edit(int $ID_Requisito)
    {
        $requisito = RequisitosCliente::find($ID_Requisito);
        $proyectos = Proyecto::all();
        return view('requisitos.formulario', compact('requisito', 'proyectos'));
    }

    public function update(Request $request, int $ID_Requisito)
    {
        $descripcion = $request->input('descripcion');
        $tipo = $request->input('tipo');
        $idProyecto = $request->input('id_proyecto');

        DB::statement('CALL ActualizarRequisitoCliente(?, ?, ?, ?)', [$ID_Requisito, $descripcion, $tipo, $idProyecto]);
        return redirect()->route('requisitos.index')->with(['message' => 'Requisito actualizado satisfactoriamente', 'type' => 'success']);
    }

    public function destroy($ID_Requisito)
    {
        DB::statement('CALL EliminarRequisitoCliente(?)', [$ID_Requisito]);
        return redirect()->route('requisitos.index')->with(['message' => 'Requisito eliminado satisfactoriamente', 'type' => 'success']);
    }
}
