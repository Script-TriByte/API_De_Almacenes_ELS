<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoArticulo extends Model
{
    use HasFactory, SoftDeletes;

    public function articulos()
    {
        return $this->belongsToMany(Articulo::class);
    }

    protected $primaryKey = 'idTipoArticulo';

    protected $table = 'tipoArticulo';

    protected $fillable = [
        'tipo',
        'nombre'
    ];
}
