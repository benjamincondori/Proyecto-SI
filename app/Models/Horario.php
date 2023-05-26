<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'horario';
    protected $fillable = ['id', 'descripcion', 'hora_inicio', 'hora_fin'];
}
