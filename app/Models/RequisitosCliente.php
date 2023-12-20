<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitosCliente extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'requisitos_cliente';
    protected $primaryKey = 'ID_Requisito';

    protected $fillable = [
        'Descripcion',
        'Tipo',
        'ID_Proyecto'
    ];

    // Definir la relación con el modelo Proyecto
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'ID_Proyecto', 'ID_Proyecto');
    }

}
