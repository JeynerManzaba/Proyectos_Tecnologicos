<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraAuto extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'ComprasAutos';
    protected $primaryKey = 'ID_Compra';

    protected $fillable = [
        'FechaCompra',
        'ID_Auto',
        'ID_Cliente',
        'CantidadComprada',
        'PrecioTotal'
    ];

    public function auto()
    {
        return $this->belongsTo(Auto::class, 'ID_Auto', 'ID_Auto');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'ID_Cliente', 'ID_Cliente'); // Ajusta el modelo Cliente y la clave primaria según tu estructura real
    }

}
