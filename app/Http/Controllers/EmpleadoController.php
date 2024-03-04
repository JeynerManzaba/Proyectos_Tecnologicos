<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Empleado;
use App\Models\Rol;
use App\Models\Habilidad;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::with(['rol', 'habilidades'])->get();
        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        $roles = Rol::all();
        $habilidades = Habilidad::all();
        return view('empleados.formulario', compact('roles', 'habilidades'));
    }

    public function store(Request $request)
    {
        // Validación de datos
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:empleados,Correo_Electronico'
        ],
        [
            'correo.required' => 'El campo correo electrónico es obligatorio.',
            'correo.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'correo.unique' => 'Ya existe un empleado con este correo electrónico.',
        ]);

        // Manejo de errores de validación
        if ($validator->fails()) {
            return redirect()
                ->route('empleados.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Creación de empleado y asociación de habilidades
        $nombre = $request->input('nombre');
        $correo = $request->input('correo');
        $rolID = $request->input('rol_id');

        $empleado = Empleado::create([
            'Nombre' => $nombre,
            'Correo_Electronico' => $correo,
            'Rol_ID' => $rolID,
        ]);

        // Adjuntar habilidades al empleado recién creado
        $empleado->habilidades()->sync($request->input('habilidades', []));

        return redirect()->route('empleados.index')->with(['message' => 'Empleado creado satisfactoriamente', 'type' => 'success']);
    }

    public function edit(int $ID_Empleado)
    {
        $empleado = Empleado::with('habilidades')->find($ID_Empleado);
        $roles = Rol::all();
        $habilidades = Habilidad::all();
        return view('empleados.formulario', compact('empleado', 'roles', 'habilidades'));
    }

    public function update(Request $request, int $ID_Empleado)
    {
        // Validación de datos
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:empleados,Correo_Electronico,' . $ID_Empleado . ',ID_Empleado'
        ],
        [
            'correo.required' => 'El campo correo electrónico es obligatorio.',
            'correo.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'correo.unique' => 'Ya existe un empleado con este correo electrónico.',
        ]);

        // Manejo de errores de validación
        if ($validator->fails()) {
            return redirect()
                ->route('empleados.edit', $ID_Empleado)
                ->withErrors($validator)
                ->withInput();
        }

        // Actualización de empleado y habilidades
        $nombre = $request->input('nombre');
        $correo = $request->input('correo');
        $rolID = $request->input('rol_id');

        $empleado = Empleado::find($ID_Empleado);
        $empleado->update([
            'Nombre' => $nombre,
            'Correo_Electronico' => $correo,
            'Rol_ID' => $rolID,
        ]);

        // Actualizar habilidades del empleado
        $empleado->habilidades()->sync($request->input('habilidades', []));

        return redirect()->route('empleados.index')->with(['message' => 'Empleado actualizado satisfactoriamente', 'type' => 'success']);
    }

    public function destroy($ID_Empleado)
    {
        DB::statement('exec [EliminarEmpleado] ?', [$ID_Empleado]);
        return redirect()->route('empleados.index')->with(['message' => 'Empleado eliminado satisfactoriamente', 'type' => 'success']);
    }
}
