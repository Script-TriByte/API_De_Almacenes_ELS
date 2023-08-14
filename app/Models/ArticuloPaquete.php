<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticuloPaquete extends Model
{
    use HasFactory;

    protected $primaryKey = 'idRelacion';

    protected $table = 'Articulo_Paquete';

    protected $fillable = [
        'idRelacion',
        'idArticulo',
        'idPaquete'
    ];
}