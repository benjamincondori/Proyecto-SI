<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class grupo_inscripcion extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'GRUPO_INSCRIPCION';
    protected $fillable = ['id_inscripcion', 'id_grupo'];
}
