<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cliente extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'CLIENTE';
    protected $fillable = ['id', 'ci', 'nombres', 'apellidos', 'fecha_nacimiento', 'telefono', 'email', 'genero', 'fotografia', 'id_usuario'];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function inscripciones(): HasMany {
        return $this->hasMany(Inscripcion::class, 'id_cliente');
    }

    public function alquileres(): HasMany {
        return $this->hasMany(Alquiler::class, 'id_cliente');
    }

    public function pagos(): HasMany {
        return $this->hasMany(Pago::class, 'id_cliente');
    }

    public function historialMedico(): HasOne {
        return $this->hasOne(Historial_Medico::class, 'id_cliente');
    }

}
