<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Inscripcion extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'INSCRIPCION';
    protected $fillable = ['id', 'fecha_inscripcion', 'fecha_inicio', 'id_cliente', 'id_administrativo', 'id_paquete', 'id_duracion', 'id_pago'];

    public function cliente(): BelongsTo {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function administrativo(): BelongsTo {
        return $this->belongsTo(Administrativo::class, 'id_administrativo');
    }

    public function paquete(): BelongsTo {
        return $this->belongsTo(Paquete::class, 'id_paquete');
    }

    public function duracion(): BelongsTo {
        return $this->belongsTo(Duracion::class, 'id_duracion');
    }

    public function detalle(): HasOne
    {
        return $this->hasOne(Detalle_Inscripcion::class, 'id_inscripcion');
    }

    public function grupos():BelongsToMany {
        return $this->belongsToMany(Grupo::class, 'GRUPO_INSCRIPCION', 'id_inscripcion', 'id_grupo');
    }

    public function pago(): BelongsTo {
        return $this->belongsTo(Pago::class, 'id_pago');
    }

}
