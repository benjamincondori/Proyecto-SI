<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alquiler extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'ALQUILER';
    protected $fillable = ['id', 'dias_duracion', 'fecha_alquiler', 'fecha_inicio', 'fecha_fin', 'estado', 'id_casillero', 'id_cliente', 'id_administrativo', 'id_pago'];

    public function cliente(): BelongsTo {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function administrativo(): BelongsTo {
        return $this->belongsTo(Administrativo::class, 'id_administrativo');
    }

    public function pago(): BelongsTo {
        return $this->belongsTo(Pago::class, 'id_pago');
    }

    public function casillero(): BelongsTo {
        return $this->belongsTo(Casillero::class, 'id_casillero');
    }

}
