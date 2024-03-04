<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tienda;

class TiendaController extends Controller
{
    public function index()
    {
        $tiendas = Tienda::all();
        return view('tiendas.index', compact('tiendas'));
    }

    public function create()
    {
        return view('tiendas.formulario');
    }

    public function store(Request $request)
    {
        $nombre = $request->input('nombre');
        $direccion = $request->input('direccion');

        DB::statement('exec [CrearTienda] ?, ?', [$nombre, $direccion]);
        return redirect()->route('tiendas.index')->with(['message' => 'Tienda de auto creada satisfactoriamente', 'type' => 'success']);
    }

    public function edit($ID_Tienda)
    {
        $tienda = Tienda::find($ID_Tienda);
        return view('tiendas.formulario', compact('tienda'));
    }

    public function update(Request $request, $ID_Tienda)
    {
        $nombre = $request->input('nombre');
        $direccion = $request->input('direccion');

        DB::statement('exec [ActualizarTienda] ?, ?, ?', [$ID_Tienda, $nombre, $direccion]);
        return redirect()->route('tiendas.index')->with(['message' => 'Tienda de auto actualizada satisfactoriamente', 'type' => 'success']);
    }

    public function destroy($ID_Tienda)
    {
        DB::statement('exec [EliminarTienda] ?', [$ID_Tienda]);
        return redirect()->route('tiendas.index')->with(['message' => 'Tienda de auto eliminada satisfactoriamente', 'type' => 'success']);
    }
}
