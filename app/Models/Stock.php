<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'StockTiendas';

    protected $fillable = [
        'ID_Tienda',
        'ID_Auto',
        'CantidadEnStock',
    ];
}
