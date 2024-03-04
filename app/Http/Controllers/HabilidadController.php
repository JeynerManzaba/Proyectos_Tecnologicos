<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Habilidad;

class HabilidadController extends Controller
{
    public function index()
    {
        $habilidades = Habilidad::all();
        return view('habilidades.index', compact('habilidades'));
    }

    public function create()
    {
        return view('habilidades.formulario');
    }

    public function store(Request $request)
    {
        $descripcion = $request->input('descripcion');
        $nivelDificultad = $request->input('nivel_dificultad');

        DB::statement('exec [CrearHabilidad] ?, ?', [$descripcion, $nivelDificultad]);
        return redirect()->route('habilidades.index')->with(['message' => 'Habilidad creada satisfactoriamente', 'type' => 'success']);
    }

    public function edit(int $ID_Habilidad)
    {
        $habilidad = Habilidad::find($ID_Habilidad);
        return view('habilidades.formulario', compact('habilidad'));
    }

    public function update(Request $request, int $ID_Habilidad)
    {
        $descripcion = $request->input('descripcion');
        $nivelDificultad = $request->input('nivel_dificultad');

        DB::statement('exec [ActualizarHabilidad] ?, ?, ?', [$ID_Habilidad, $descripcion, $nivelDificultad]);
        return redirect()->route('habilidades.index')->with(['message' => 'Habilidad actualizada satisfactoriamente', 'type' => 'success']);
    }

    public function destroy($ID_Habilidad)
    {
        DB::statement('exec [EliminarHabilidad] ?', [$ID_Habilidad]);
        return redirect()->route('habilidades.index')->with(['message' => 'Habilidad eliminada satisfactoriamente', 'type' => 'success']);
    }
}
