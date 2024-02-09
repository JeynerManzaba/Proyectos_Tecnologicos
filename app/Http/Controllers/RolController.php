<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Rol;
use App\Models\Error;

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
        try {
            $descripcion = $request->input('descripcion');

            DB::beginTransaction();

            // Ejecutar la operación de base de datos
            DB::statement('CALL CrearRol(?)', [$descripcion]);

            // Confirmar la transacción
           // DB::commit();

            return redirect()->route('roles.index')->with(['message' => 'Rol creado satisfactoriamente', 'type' => 'success']);
        } catch (\Illuminate\Database\QueryException $ex) {
            // Si ocurre un error, revertir la transacción y registrar en la tabla de errores
            DB::rollBack();

            $this->registrarError('UsuarioReportes', 'CREATE ROLE', 'IP_Donde_Fue_Disparada', $ex->getMessage());

            return redirect()->route('roles.index')->with(['message' => 'Error al crear el rol. Consulta la tabla de errores para más detalles.', 'type' => 'error']);
        }
    }

    public function edit(int $ID_Rol)
    {
        $rol = Rol::find($ID_Rol);
        return view('roles.formulario', compact('rol'));
    }

    public function update(Request $request, int $ID_Rol)
    {
        try {
            $descripcion = $request->input('descripcion');

            DB::beginTransaction();
            DB::statement('CALL ActualizarRol(?, ?)', [$ID_Rol, $descripcion]);
            DB::commit();

            return redirect()->route('roles.index')->with(['message' => 'Rol actualizado satisfactoriamente', 'type' => 'success']);
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            $this->registrarError('UsuarioReportes', 'UPDATE ROLE', 'IP_Donde_Fue_Disparada', $ex->getMessage());
            return redirect()->route('roles.index')->with(['message' => 'Error al actualizar el rol. Consulta la tabla de errores para más detalles.', 'type' => 'error']);
        }
    }

    public function destroy($ID_Rol)
    {
        try {
            DB::beginTransaction();
            DB::statement('CALL EliminarRol(?)', [$ID_Rol]);
            DB::commit();
            return redirect()->route('roles.index')->with(['message' => 'Rol eliminado satisfactoriamente', 'type' => 'success']);
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            $this->registrarError('UsuarioReportes', 'DELETE ROLE', 'IP_Donde_Fue_Disparada', $ex->getMessage());
            return redirect()->route('roles.index')->with(['message' => 'Error al eliminar el rol. Consulta la tabla de errores para más detalles.', 'type' => 'error']);
        }
    }

    private function registrarError($usuario, $sentenciaIncorrecta, $ip, $motivoError)
    {
        Error::create([
            'Usuario' => $usuario,
            'Sentencia_Incorrecta' => $sentenciaIncorrecta,
            'IP' => $ip,
            'Fecha_Hora' => now(),
            'Motivo_Error' => $motivoError,
        ]);
    }
}
