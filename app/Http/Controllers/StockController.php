<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Tienda;
use App\Models\Auto;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with(['tienda', 'auto'])->get();
        return view('stocks.index', compact('stocks'));
    }

    public function create()
    {
        $tiendas = Tienda::all();
        $autos = Auto::all();
        return view('stocks.formulario', compact('tiendas', 'autos'));
    }

    public function store(Request $request)
    {
        $idTienda = $request->input('id_tienda');
        $idAuto = $request->input('id_auto');
        $cantidadEnStock = $request->input('cantidad_en_stock');

        Stock::create([
            'ID_Tienda' => $idTienda,
            'ID_Auto' => $idAuto,
            'CantidadEnStock' => $cantidadEnStock,
        ]);

        return redirect()->route('stocks.index')->with(['message' => 'Stock creado satisfactoriamente', 'type' => 'success']);
    }

    public function edit($id)
    {
        $stock = Stock::with(['tienda', 'auto'])->find($id);
        $tiendas = Tienda::all();
        $autos = Auto::all();
        return view('stocks.formulario', compact('stock', 'tiendas', 'autos'));
    }

    public function update(Request $request, $id)
    {
        $idTienda = $request->input('id_tienda');
        $idAuto = $request->input('id_auto');
        $cantidadEnStock = $request->input('cantidad_en_stock');

        $stock = Stock::find($id);
        $stock->update([
            'ID_Tienda' => $idTienda,
            'ID_Auto' => $idAuto,
            'CantidadEnStock' => $cantidadEnStock,
        ]);

        return redirect()->route('stocks.index')->with(['message' => 'Stock actualizado satisfactoriamente', 'type' => 'success']);
    }

    public function destroy($id)
    {
        Stock::destroy($id);

        return redirect()->route('stocks.index')->with(['message' => 'Stock eliminado satisfactoriamente', 'type' => 'success']);
    }
}
