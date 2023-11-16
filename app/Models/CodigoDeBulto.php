<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigoDeBulto extends Model
{
    use HasFactory;

    protected $primaryKey = 'codigo';

    protected $table = 'codigoDeBulto';

    protected $fillable = [
        'codigo',
        'tipo',
        'maximoApilado'
    ];
}
