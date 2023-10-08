<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrenador_Disciplina extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'ENTRENADOR_DISCIPLINA';
    protected $fillable = ['id_disciplina', 'id_entrenador'];

}
