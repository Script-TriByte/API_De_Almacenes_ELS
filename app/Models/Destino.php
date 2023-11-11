<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destino extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'idDestino';

    protected $table = 'destinos';

    protected $fillable = [
        'direccion',
        'idDepartamento'
    ];
}
