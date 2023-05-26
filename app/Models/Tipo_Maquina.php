<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_Maquina extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'tipo_maquina';
    protected $fillable = ['id', 'nombre', 'descripcion'];
}
