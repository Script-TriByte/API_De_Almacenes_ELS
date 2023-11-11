<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lote extends Model
{
    use HasFactory, SoftDeletes;

    public function paquetes()
    {
        return $this->hasMany(Paquete::class, 'idPaquete');
    }

    protected $primaryKey = 'idLote';

    protected $table = 'lotes';

    protected $fillable = [
        'idLote',
        'cantidadPaquetes',
        'idDestino',
        'idAlmacen'
    ];
}
