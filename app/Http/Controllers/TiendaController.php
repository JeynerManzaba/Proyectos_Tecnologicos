<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tienda;

class TiendaController extends Controller
{
    public function index()
    {
        $tiendasAutos = Tienda::all();
        return view('tiendas_autos.index', compact('tiendasAutos'));
    }

    public function create()
    {
        return view('tiendas_autos.formulario');
    }

    public function store(Request $request)
    {
        $nombre = $request->input('nombre');
        $direccion = $request->input('direccion');

        DB::statement('exec [CrearTiendaAuto] ?, ?', [$nombre, $direccion]);
        return redirect()->route('tiendas_autos.index')->with(['message' => 'Tienda de auto creada satisfactoriamente', 'type' => 'success']);
    }

    public function edit($ID_Tienda)
    {
        $tiendaAuto = Tienda::find($ID_Tienda);
        return view('tiendas_autos.formulario', compact('tiendaAuto'));
    }

    public function update(Request $request, $ID_Tienda)
    {
        $nombre = $request->input('nombre');
        $direccion = $request->input('direccion');

        DB::statement('exec [ActualizarTiendaAuto] ?, ?, ?', [$ID_Tienda, $nombre, $direccion]);
        return redirect()->route('tiendas_autos.index')->with(['message' => 'Tienda de auto actualizada satisfactoriamente', 'type' => 'success']);
    }

    public function destroy($ID_Tienda)
    {
        DB::statement('exec [EliminarTiendaAuto] ?', [$ID_Tienda]);
        return redirect()->route('tiendas_autos.index')->with(['message' => 'Tienda de auto eliminada satisfactoriamente', 'type' => 'success']);
    }
}
