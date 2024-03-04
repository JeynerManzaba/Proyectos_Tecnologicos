<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraAuto extends Model
{
    use HasFactory;
    protected $table = 'ComprasAutos';
    protected $primaryKey = 'ID_Compra';

    protected $fillable = [
        'FechaCompra',
        'ID_Auto',
        'ID_Cliente',
        'CantidadComprada',
        'PrecioTotal',
    ];
}
