<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Administrativo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $fillable = ['id', 'cargo'];
    protected $table = 'ADMINISTRATIVO';

    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class, 'id');
    } 

    public function inscripciones():HasMany {
        return $this->hasMany(Inscripcion::class, 'id_administrativo');
    }

    public function alquileres():HasMany {
        return $this->hasMany(Alquiler::class, 'id_administrativo');
    }

    public function asistencias(): HasMany {
        return $this->hasMany(Asistencia::class, 'id_administrativo');
    }

    public function pagos():HasMany {
        return $this->hasMany(Pago::class, 'id_administrativo');
    }

}
