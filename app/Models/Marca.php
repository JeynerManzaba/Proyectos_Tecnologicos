<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    protected $table = 'MarcasAutos';
    protected $primaryKey = 'ID_Marca';

    protected $fillable = [
        'Nombre',
    ];
}
