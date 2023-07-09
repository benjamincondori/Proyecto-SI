<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pago extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'PAGO';
    protected $fillable = ['id', 'concepto', 'fecha', 'monto', 'efectivo', 'cambio', 'id_administrativo', 'id_cliente'];

    public function cliente(): BelongsTo {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function administrativo(): BelongsTo {
        return $this->belongsTo(Administrativo::class, 'id_administrativo');
    }

    public function inscripcion(): HasOne {
        return $this->hasOne(Inscripcion::class, 'id_pago');
    }

    public function alquiler(): HasOne {
        return $this->hasOne(Alquiler::class, 'id_pago');
    }

    public function factura(): HasOne {
        return $this->hasOne(Factura::class, 'id_pago');
    }

}
