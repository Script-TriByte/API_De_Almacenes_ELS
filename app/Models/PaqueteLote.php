<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaqueteLote extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'idPaquete';

    protected $table = 'paquete_lote';

    protected $fillable = [
        'idPaquete',
        'idLote'
    ];
}