<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Marca;

class MarcaController extends Controller
{
    public function index()
    {
        $marcasAutos = Marca::all();
        return view('marcas_autos.index', compact('marcasAutos'));
    }

    public function create()
    {
        return view('marcas_autos.formulario');
    }

    public function store(Request $request)
    {
        $nombre = $request->input('nombre');

        DB::statement('exec [CrearMarcaAuto] ?', [$nombre]);
        return redirect()->route('marcas_autos.index')->with(['message' => 'Marca de auto creada satisfactoriamente', 'type' => 'success']);
    }

    public function edit($ID_Marca)
    {
        $marcaAuto = Marca::find($ID_Marca);
        return view('marcas_autos.formulario', compact('marcaAuto'));
    }

    public function update(Request $request, $ID_Marca)
    {
        $nombre = $request->input('nombre');

        DB::statement('exec [ActualizarMarcaAuto] ?, ?', [$ID_Marca, $nombre]);
        return redirect()->route('marcas_autos.index')->with(['message' => 'Marca de auto actualizada satisfactoriamente', 'type' => 'success']);
    }

    public function destroy($ID_Marca)
    {
        DB::statement('exec [EliminarMarcaAuto] ?', [$ID_Marca]);
        return redirect()->route('marcas_autos.index')->with(['message' => 'Marca de auto eliminada satisfactoriamente', 'type' => 'success']);
    }
}
