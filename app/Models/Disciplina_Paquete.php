<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disciplina_Paquete extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'DISCIPLINA_PAQUETE';
    protected $fillable = ['id_disciplina', 'id_paquete'];

}
