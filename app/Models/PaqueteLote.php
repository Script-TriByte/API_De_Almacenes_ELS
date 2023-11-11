<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaqueteLote extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'idRelacion';

    protected $table = 'paquete_lote';

    protected $fillable = [
        'idRelacion',
        'idPaquete',
        'idLote'
    ];
}