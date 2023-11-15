<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticuloTipoArticulo extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'idRelacion';

    protected $table = 'articulo_tipoArticulo';

    protected $fillable = [
        'idArticulo',
        'idTipo'
    ];
}
