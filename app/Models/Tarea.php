<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'tareas';
    protected $primaryKey = 'ID_Tarea';

    protected $fillable = [
        'Descripcion',
        'Estado',
        'Fecha_Inicio',
        'Fecha_Fin',
        'ID_Empleado',
        'ID_Proyecto',
    ];

    // Relación con el modelo Empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'ID_Empleado', 'ID_Empleado');
    }

    // Relación con el modelo Proyecto
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'ID_Proyecto', 'ID_Proyecto');
    }
}
