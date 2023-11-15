<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Articulo extends Model
{
    use HasFactory, SoftDeletes;

    public function paquete(){
        return $this->belongsTo(Paquete::class, 'idPaquete');
    }

    public function tipoArticulos()
    {
        return $this->belongsToMany(TipoArticulo::class);
    }

    protected $primaryKey = 'idArticulo';

    protected $table = 'articulos';

    protected $fillable = [
        'idArticulo',
        'nombre',
        'anioCreacion'
    ];
}
