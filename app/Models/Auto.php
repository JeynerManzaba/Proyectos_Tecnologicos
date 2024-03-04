<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    use HasFactory;
    protected $table = 'Autos';
    protected $primaryKey = 'ID_Auto';

    protected $fillable = [
        'Modelo',
        'Año',
        'Precio',
        'ID_Marca',
        'Stock',
    ];
}
