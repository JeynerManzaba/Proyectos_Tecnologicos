<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'proyectos';
    protected $primaryKey = 'ID_Proyecto';

    protected $fillable = [
        'Nombre',
        'Descripcion',
        'Fecha_Inicio',
        'Fecha_Fin',
        'Estado',
        'ID_Cliente'
    ];

     // Relación con el modelo Cliente
     public function cliente()
     {
        return $this->belongsTo(Cliente::class, 'ID_Cliente', 'ID_Cliente');
     }
}
