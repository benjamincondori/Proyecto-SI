<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paquete_Duracion extends Model
{
    use HasFactory;

    public $timestamps = false;
    // protected $primaryKey = ['id_paquete', 'id_duracion'];
    protected $table = 'PAQUETE_DURACION';
    protected $fillable = ['id_paquete', 'id_duracion', 'precio', 'descuento'];

}
