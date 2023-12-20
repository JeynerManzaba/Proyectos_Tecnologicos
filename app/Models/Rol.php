<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

     protected $table = 'roles'; // Asegúrate de que la tabla esté especificada correctamente
     protected $primaryKey = 'ID_Rol';

     protected $fillable = [
         'Descripcion'
     ];
}
