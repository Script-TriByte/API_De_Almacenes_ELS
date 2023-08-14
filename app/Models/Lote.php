<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lote extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'idLote';

    protected $table = 'Lotes';

    protected $fillable = [
        'idLote',
        'cantidadPaquetes'
    ];
}