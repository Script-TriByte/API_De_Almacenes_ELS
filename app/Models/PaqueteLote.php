<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaqueteLote extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'idRelacion';

    protected $table = 'Paquete_Lote';

    protected $fillable = [
        'idRelacion',
        'idPaquete',
        'idLote'
    ];
}