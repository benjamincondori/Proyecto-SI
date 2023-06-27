<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Empleado extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'EMPLEADO';
    protected $fillable = ['id', 'ci', 'nombres', 'apellidos', 'fecha_nacimiento', 'direccion', 'telefono', 'email', 'genero', 'turno', 'fotografia', 'tipo_empleado', 'id_usuario'];

    public function administrativo(): HasOne {
        return $this->hasOne(Administrativo::class, 'id');
    }

    public function entrenador(): HasOne {
        return $this->hasOne(Entrenador::class, 'id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

}
