<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{
    use HasFactory;

    protected $primaryKey = 'idPaquete';

    protected $table = 'paquetes';

    protected $fillable = [
        'idPaquete',
        'cantidadArticulos',
        'peso'
    ];

    public function articulos()
    {
        return $this->hasMany(Articulo::class, 'idArticulo');
    }

    public function lote(){
        return $this->belongsTo(Lote::class, 'idLote');
    }

    public function estanteria(){
        return $this->belongsTo(Estanteria::class, 'identificador');
    }
}
