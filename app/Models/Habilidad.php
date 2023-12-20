<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habilidad extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'habilidades';
    protected $primaryKey = 'ID_Habilidad';

    protected $fillable = [
        'Descripcion',
        'Nivel_Dificultad'
    ];
}
