<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Grupo extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'GRUPO';
    protected $fillable = ['id', 'nombre', 'nro_integrantes', 'id_disciplina', 'id_entrenador', 'id_horario'];

    public function horario():BelongsTo
    {
        return $this->belongsTo(Horario::class, 'id_horario');
    }

    public function entrenador():BelongsTo
    {
        return $this->belongsTo(Entrenador::class, 'id_entrenador');
    }

    public function disciplina():BelongsTo
    {
        return $this->belongsTo(Disciplina::class, 'id_disciplina');
    }

    public function inscripciones():BelongsToMany {
        return $this->belongsToMany(Inscripcion::class, 'GRUPO_INSCRIPCION', 'id_grupo', 'id_inscripcion');
    }
}
