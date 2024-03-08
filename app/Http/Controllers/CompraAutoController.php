<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompraAuto;
use App\Models\Auto;
use App\Models\Cliente;

class CompraAutoController extends Controller
{
    public function index()
    {
        $compras = CompraAuto::with('auto', 'cliente')->get();
        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        $autos = Auto::all();
        $clientes = Cliente::all();
        return view('compras.formulario', compact('autos', 'clientes'));
    }

    public function store(Request $request)
    {
        // Validación de formulario (ajústala según tus necesidades)
        $request->validate([
            'ID_Auto' => 'required|exists:autos,ID_Auto',
            'ID_Cliente' => 'required|exists:clientes,ID_Cliente',
            'FechaCompra' => 'required|date',
            'CantidadComprada' => 'required|numeric',
        ]);

        // Obtener el auto seleccionado
        $auto = Auto::find($request->input('ID_Auto'));

        // Calcular el precio total
        $precioTotal = $auto->Precio * $request->input('CantidadComprada');

        // Crear una nueva compra usando Eloquent
        $compra = new CompraAuto([
            'ID_Auto' => $request->input('ID_Auto'),
            'ID_Cliente' => $request->input('ID_Cliente'),
            'FechaCompra' => $request->input('FechaCompra'),
            'CantidadComprada' => $request->input('CantidadComprada'),
            'PrecioTotal' => $precioTotal,
        ]);

        $compra->save();

        return redirect()->route('compras.index')->with(['message' => 'Compra creada satisfactoriamente', 'type' => 'success']);
    }

    public function edit($ID_Compra)
    {
        $compra = CompraAuto::findOrFail($ID_Compra);
        $autos = Auto::all();
        $clientes = Cliente::all();
        return view('compras.formulario', compact('compra', 'autos', 'clientes'));
    }

    public function update(Request $request, $ID_Compra)
    {
        // Validación de formulario (ajústala según tus necesidades)
        $request->validate([
            'ID_Auto' => 'required|exists:autos,ID_Auto',
            'ID_Cliente' => 'required|exists:clientes,ID_Cliente',
            'FechaCompra' => 'required|date',
            'CantidadComprada' => 'required|numeric',
        ]);

        // Obtener el auto seleccionado
        $auto = Auto::find($request->input('ID_Auto'));

        // Calcular el precio total
        $precioTotal = $auto->Precio * $request->input('CantidadComprada');

        // Actualizar la compra usando Eloquent
        $compra = CompraAuto::findOrFail($ID_Compra);
        $compra->update([
            'ID_Auto' => $request->input('ID_Auto'),
            'ID_Cliente' => $request->input('ID_Cliente'),
            'FechaCompra' => $request->input('FechaCompra'),
            'CantidadComprada' => $request->input('CantidadComprada'),
            'PrecioTotal' => $precioTotal,
        ]);

        return redirect()->route('compras.index')->with(['message' => 'Compra actualizada satisfactoriamente', 'type' => 'success']);
    }

    public function destroy($ID_Compra)
    {
        // Eliminar la compra usando Eloquent
        $compra = CompraAuto::findOrFail($ID_Compra);
        $compra->delete();

        return redirect()->route('compras.index')->with(['message' => 'Compra eliminada satisfactoriamente', 'type' => 'success']);
    }
}
