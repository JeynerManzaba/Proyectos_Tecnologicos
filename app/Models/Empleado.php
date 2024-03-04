<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    public $timestamps = false;


    protected $table = 'empleados';
    protected $primaryKey = 'ID_Empleado';
    protected $fillable = [
        'Nombre',
        'Correo_Electronico',
        'Rol_ID'
    ];


    public function rol()
    {
        return $this->belongsTo(Rol::class, 'Rol_ID', 'ID_Rol');
    }


    public function habilidades()
    {
        return $this->belongsToMany(Habilidad::class, 'empleado_habilidad', 'ID_Empleado', 'ID_Habilidad');
    }


    public function tiendas()
    {
        return $this->belongsToMany(Tienda::class, 'EmpleadosTiendas', 'ID_Empleado', 'ID_Tienda');
    }

}
