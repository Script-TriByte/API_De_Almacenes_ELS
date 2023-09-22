<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estanteria extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'identificador';

    protected $table = 'estanterias';

    protected $fillable = [
        'peso',
        'apiladoMaximo',
        'idAlmacen'
    ];
}
