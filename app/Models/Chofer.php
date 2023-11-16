<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chofer extends Model
{
    use HasFactory;

    protected $primaryKey = 'docDeIdentidad';

    protected $table = 'choferes';

    protected $fillable = [
        'docDeIdentidad'
    ];
}
