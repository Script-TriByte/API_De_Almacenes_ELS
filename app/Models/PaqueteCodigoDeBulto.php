<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaqueteCodigoDeBulto extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'idRelacion';

    protected $table = 'paquete_codigoDeBulto';

    protected $fillable = [
        'idRelacion',
        'idPaquete',
        'codigo'
    ];
}
