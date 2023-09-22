<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehiculoLoteDestino extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'idLote';

    protected $table = 'vehiculo_lote_destino';

    protected $fillable = [
        'fechaEstimada',
        'horaEstimada',
        'docDeIdentidad'
    ];
}