<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auto;

class AutoController extends Controller
{
    public function index()
    {
        $autos = Auto::all();
        return view('autos.index', compact('autos'));
    }

    public function create()
    {
        // Puedes pasar la lista de marcas de autos a la vista si es necesario
        $marcasAutos = DB::table('MarcasAutos')->get();
        return view('autos.formulario', compact('marcasAutos'));
    }

    public function store(Request $request)
    {
        $modelo = $request->input('modelo');
        $año = $request->input('año');
        $precio = $request->input('precio');
        $idMarca = $request->input('id_marca');
        $stock = $request->input('stock');

        DB::statement('exec [CrearAuto] ?, ?, ?, ?, ?', [$modelo, $año, $precio, $idMarca, $stock]);
        return redirect()->route('autos.index')->with(['message' => 'Auto creado satisfactoriamente', 'type' => 'success']);
    }

    public function edit($ID_Auto)
    {
        $auto = Auto::find($ID_Auto);
        $marcasAutos = DB::table('MarcasAutos')->get();
        return view('autos.formulario', compact('auto', 'marcasAutos'));
    }

    public function update(Request $request, $ID_Auto)
    {
        $modelo = $request->input('modelo');
        $año = $request->input('año');
        $precio = $request->input('precio');
        $idMarca = $request->input('id_marca');
        $stock = $request->input('stock');

        DB::statement('exec [ActualizarAuto] ?, ?, ?, ?, ?, ?', [$ID_Auto, $modelo, $año, $precio, $idMarca, $stock]);
        return redirect()->route('autos.index')->with(['message' => 'Auto actualizado satisfactoriamente', 'type' => 'success']);
    }

    public function destroy($ID_Auto)
    {
        DB::statement('exec [EliminarAuto] ?', [$ID_Auto]);
        return redirect()->route('autos.index')->with(['message' => 'Auto eliminado satisfactoriamente', 'type' => 'success']);
    }
}
