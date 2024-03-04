<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Rol;


class RolController extends Controller
{
    public function index()
    {
        $roles = Rol::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.formulario');
    }

    public function store(Request $request)
    {
        $descripcion = $request->input('descripcion');

        DB::statement('exec CrearRol ?', [$descripcion]);

        return redirect()->route('roles.index')->with(['message' => 'Rol creado satisfactoriamente', 'type' => 'success']);
    }

    public function edit(int $ID_Rol)
    {
        $rol = Rol::find($ID_Rol);
        return view('roles.formulario', compact('rol'));
    }

    public function update(Request $request, int $ID_Rol)
    {
        $descripcion = $request->input('descripcion');
        DB::statement('exec ActualizarRol ?, ?', [$ID_Rol, $descripcion]);
        return redirect()->route('roles.index')->with(['message' => 'Rol actualizado satisfactoriamente', 'type' => 'success']);
    }

    public function destroy($ID_Rol)
    {
        DB::statement('exec EliminarRol ?', [$ID_Rol]);
        return redirect()->route('roles.index')->with(['message' => 'Rol eliminado satisfactoriamente', 'type' => 'success']);
    }

}
