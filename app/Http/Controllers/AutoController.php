<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auto;
use App\Models\Marca;

class AutoController extends Controller
{
    public function index()
    {
        $autos = Auto::with('marca')->get();
        return view('autos.index', compact('autos'));
    }

    public function create()
    {
        $marcas = Marca::all();
        return view('autos.formulario', compact('marcas'));
    }

    public function store(Request $request)
    {
        // Obtener datos del formulario
        $modelo = $request->input('modelo');
        $ano = $request->input('ano');
        $precio = $request->input('precio');
        $idMarca = $request->input('id_marca');
        $stock = $request->input('stock');

        // Llamar al procedimiento almacenado para crear un auto
        DB::statement('exec CrearAuto ?, ?, ?, ?, ?', [$modelo, $ano, $precio, $idMarca, $stock]);

        return redirect()->route('autos.index')->with(['message' => 'Auto creado satisfactoriamente', 'type' => 'success']);
    }

    public function edit($ID_Auto)
    {
        $auto = Auto::with('marca')->find($ID_Auto);
        $marcas = Marca::all();
        return view('autos.formulario', compact('auto', 'marcas'));
    }

    public function update(Request $request, $ID_Auto)
    {
        // Obtener datos del formulario
        $modelo = $request->input('modelo');
        $ano = $request->input('ano');
        $precio = $request->input('precio');
        $idMarca = $request->input('id_marca');
        $stock = $request->input('stock');

        // Llamar al procedimiento almacenado para actualizar un auto
        DB::statement('exec ActualizarAuto ?, ?, ?, ?, ?, ?', [$ID_Auto, $modelo, $ano, $precio, $idMarca, $stock]);

        return redirect()->route('autos.index')->with(['message' => 'Auto actualizado satisfactoriamente', 'type' => 'success']);
    }

    public function destroy($ID_Auto)
    {
        // Llamar al procedimiento almacenado para eliminar un auto
        DB::statement('exec EliminarAuto ?', [$ID_Auto]);

        return redirect()->route('autos.index')->with(['message' => 'Auto eliminado satisfactoriamente', 'type' => 'success']);
    }
}
