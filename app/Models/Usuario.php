<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $primaryKey = 'docDeIdentidad';

    protected $table = 'usuarios';

    protected $fillable = [
        'docDeIdentidad',
        'nombre',
        'apellido',
        'telefono',
        'direccion'
    ];
}
