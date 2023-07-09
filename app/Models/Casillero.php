<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Casillero extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['id', 'nro', 'tamaño', 'precio', 'estado'];
    protected $table = 'CASILLERO';

    public function alquileres(): HasMany {
        return $this->hasMany(Alquiler::class, 'id_casillero');
    }

}
