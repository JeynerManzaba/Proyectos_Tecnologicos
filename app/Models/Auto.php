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
        'ID_Tienda'
    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'ID_Marca', 'ID_Marca');
    }

    public function tienda()
    {
        return $this->belongsTo(Tienda::class, 'ID_Tienda', 'ID_Tienda');
    }

}
