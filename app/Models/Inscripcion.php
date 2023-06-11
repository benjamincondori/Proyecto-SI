<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'inscripcion';
    protected $fillable = ['id', 'fecha_inscripcion', 'fecha_inicio', 'id_cliente', 'id_administrativo', 'id_paquete', 'id_duracion', 'id_pago'];

}
