<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'Autos';
    protected $primaryKey = 'ID_Auto';

    protected $fillable = [
        'Modelo',
        'Año',
        'Precio',
        'ID_Marca',
        'Stock',
    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'ID_Marca', 'ID_Marca');
    }

    public function stock()
    {
        return $this->belongsToMany(Stock::class, 'StockTiendas', 'ID_Tienda', 'ID_Auto')
                     ->withPivot('CantidadEnStock');
    }
}
