<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ClienteController extends Controller

{

    public function index()
    {
         $clientes = Cliente::all();
        return view("clientes.index", compact("clientes"));
    }


    public function create()
    {
        return view("clientes.formulario");
    }

    public function store(Request $request)
    {
        // Este método se utiliza para procesar el formulario de creación.
        // Obtener los datos del formulario
        $nombre = $request->input('nombre');
        $cedula = $request->input('cedula');
        $telefono = $request->input('telefono');
        $correo = $request->input('correo');

        // Llamar al procedimiento almacenado
        $sp_cliente = DB::statement('exec CrearCliente ?, ?, ?, ?', [$nombre, $cedula, $telefono, $correo]);

        // Puedes agregar más lógica aquí según sea necesario, por ejemplo, redirigir a la vista de clientes.
        return redirect()->route('clientes.index')->with([ 'message' => 'Cliente registrado satisfactoriamente', 'type' => 'success' ]);
    }

    public function edit(int $ID_Cliente)
    {
         // Obtener el cliente que se va a editar
         $cliente = Cliente::find($ID_Cliente);
         return view('clientes.formulario', compact('cliente'));
    }

    public function update(Request $request, int $ID_Cliente)
    {
        // Obtener el cliente existente
        $cliente = Cliente::find($ID_Cliente);

        // Obtener los datos del formulario
        $nombre = $request->input('nombre');
        $cedula = $request->input('cedula');
        $telefono = $request->input('telefono');
        $correo = $request->input('correo');

            // Llamar al procedimiento almacenado de actualización
            DB::statement('exec [ActualizarCliente] ?, ?, ?, ?, ?', [$ID_Cliente, $nombre, $cedula, $telefono, $correo]);

            //  redirigir a la vista de clientes.
            return redirect()->route('clientes.index')->with([ 'message' => 'se edito un cliente satisfactoriamente', 'type' => 'success' ]);

    }
    public function destroy($ID_Cliente)
    {
        // Llamar al procedimiento almacenado de eliminación
        DB::statement('exec [EliminarCliente] ?', [$ID_Cliente]);

        // Puedes agregar más lógica aquí según sea necesario, por ejemplo, redirigir a la vista de clientes.
        return redirect()->route('clientes.index');
    }
}
