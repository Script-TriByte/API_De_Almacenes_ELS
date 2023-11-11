<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;

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
