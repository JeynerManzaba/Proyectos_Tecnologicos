<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Error extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'errores';
    protected $primaryKey = 'ID_Error';

    protected $fillable = [
        'Usuario',
        'sentencia_incorrecta',
        'ip',
        'motivo_error'
    ];

}



