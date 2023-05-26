<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grupo extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'grupo';
    protected $fillable = ['id', 'nombre', 'nro_integrantes', 'id_disciplina', 'id_entrenador', 'id_horario'];

    public function horario():BelongsTo
    {
        return $this->belongsTo(Horario::class);
    }

    public function entrenador():BelongsTo
    {
        return $this->belongsTo(Entrenador::class);
    }

    public function disciplina():BelongsTo
    {
        return $this->belongsTo(Disciplina::class);
    }
}
